<?php
namespace kakalika\projects;

use kakalika\project_users\ProjectUsersModel;
use kakalika\users\UsersModel;
use kakalika\KakalikaController;
use ntentan\Ntentan;
use ntentan\controllers\components\auth\Auth;
use ntentan\models\Model;

include "kakalika/users/Users.php";

class ProjectsController extends KakalikaController
{
    public function init()
    {
        parent::init();
        $this->addComponent("admin");
        $this->adminComponent->postAddCallback = "routeProjectSetup";
        $this->adminComponent->prefix = "admin";
        $this->adminComponent->headings = false;
        $this->adminComponent->notifications = false;
        $this->adminComponent->listFields = array(
            "name",
            "machine_name",
            "description"
        );
        $this->adminComponent->headingLevel = '4';
        
        $this->adminComponent->addOperation(
            array(
                "label"     => "Members",
                "operation" => "members"
            )
        );
        $this->set("section", "Projects");
        
        switch($this->method)
        {
            case "page":
            case "run":
                $this->subMenuWidget->addItem(
                    array(
                        "label" => "Add a new Project",
                        "url"  => "projects/add"
                    )
                );
                break;
            case "add":
                $this->set("sub_section", "Add new Project");
                break;
        }
    }

    public function routeProjectSetup($id, $project)
    {
        Ntentan::redirect(Ntentan::getUrl("admin/projects/initialize/$id"));
    }

    /**
     * 
     * @param integer $projectId
     */
    public function members($projectId, $operation = null, $operationId = null)
    {
        $project = ProjectsModel::getFirstWithId($projectId);
        if($operation == "add")
        {
            $this->view->template = "add_member.tpl.php";
            $this->set("sub_section", "Add a new Project Member to {$project->name}");
            $users = Users::getAll();
            $this->set("users", $users->toArray());
            
            if(isset($_POST["user_id"]))
            {
                $projectUser = ProjectUsers::getAll(
                    array(
                        "conditions" => array(
                            "user_id" => $_POST["user_id"],
                            "project_id" => $projectId
                        )
                    )
                );
                
                if($projectUser->count() == 0)
                {
                    $projectUser->user_id = $_POST["user_id"];
                    $projectUser->is_admin = isset($_POST["is_admin"]) ? '1' : '0';
                    $projectUser->project_id = $projectId;
                    $projectUser->save();
                    Ntentan::redirect(u("admin/projects/members/{$projectId}"));
                }
                else
                {
                    $this->set("errors", array("user_id"=>array("This user is already a member of this project")));
                }
            }
        }
        elseif($operation == "")
        {
            $users = ProjectUsers::getAllWithProjectId($projectId);
            $this->set("users", $users->toArray());
            $this->set("sub_section", "Members of {$project->name}");
            $this->set("project_id", $projectId);
            $this->subMenuBlock->addItem(
                array(
                    "label" => "Add New Project User",
                    "url" => u("admin/projects/members/{$projectId}/add")
                )
            );
        }
        elseif($operation == "delete")
        {
            $user = ProjectUsers::getFirstWithId($operationId);
            $user->delete();
            Ntentan::redirect(u("admin/projects/members/{$projectId}"));
        }
    }

    public function initialize($projectId)
    {
        $project = $this->model->getFirstWithId($projectId, array("fetch_related"=>false));
        $this->set("name", $project->name);
        $this->set("project_path", Ntentan::getUrl($project->machine_name));
        if($project->initialized == 0)
        {
            $this->view->template = "first_run.tpl.php";
            $this->set("sub_section", "Assign users to {$project->name}");
            
            if($_POST["form_submitted"] == "yes")
            {
                foreach($_POST["user_ids"] as $userId)
                {
                    $projectUser = new \kakalika\project_users\ProjectUsers();
                    $projectUser->user_id = $userId;
                    $projectUser->project_id = $projectId;
                    $projectUser->is_admin = '0';
                    $projectUser->save();
                }
                $project->initialized = 1;
                $project->update();
                Ntentan::redirect(Ntentan::getUrl($project->machine_name));
            }
            else
            {
                $users = \kakalika\users\Users::getAll(
                    array(
                        "conditions" => array(
                            "users.id<>" => Auth::userId()
                        )
                    )
                );
                if(count($users->getData()) > 0)
                {
                    $this->set("users", $users->getData());
                }
                else
                {
                    $project->initialized = 1;
                    $project->update();
                    Ntentan::redirect(Ntentan::getUrl($project->machine_name));
                }
            }
        }
    }
}
