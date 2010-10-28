<?php
namespace kakalika\projects;

use kakalika\users\UsersModel;
use kakalika\KakalikaController;
use ntentan\Ntentan;
use ntentan\controllers\components\auth\Auth;
use ntentan\models\Model;

include "kakalika/users/UsersModel.php";

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
                $this->subMenuBlock->addItem(
                    array(
                        "label" => "Add a new Project",
                        "url"  => "projects/add"
                    )
                );
                break;
        }
    }
    
    public function routeProjectSetup($id, $project)
    {
        Ntentan::redirect(Ntentan::getUrl("admin/projects/initialize/$id"));
    }
    
    public function members($projectId)
    {
        
    }
    
    public function initialize($projectId)
    {
        $project = $this->model->getFirstWithId($projectId, array("fetch_related"=>false));
        $this->set("name", $project->name);
        $this->set("project_path", Ntentan::getUrl($project->machine_name));
        if($project->initialized == 0)
        {
            $this->view->template = "first_run.tpl.php";
            $this->append("section", " :: {$project->name}");
            
            if($_POST["form_submitted"] == "yes")
            {
                foreach($_POST["user_ids"] as $userId)
                {
                    $projectUser = new \kakalika\project_users\ProjectUsersModel();
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
                $users = UsersModel::getAll(
                    array(
                        "conditions" => array(
                            "users.id<>" => Auth::userId()
                        )
                    )
                );
                $this->set("users", $users->getData());
            }
        }
    }
}
