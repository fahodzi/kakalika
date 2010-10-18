<?php
namespace kakalika\projects;

use kakalika\users\UsersModel;
use kakalika\KakalikaController;
use ntentan\Ntentan;
use ntentan\controllers\components\auth\Auth;

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
        Ntentan::redirect(Ntentan::getUrl("admin/projects/setup/$id"));
    }
    
    public function setup($projectId)
    {
        $project = $this->model->getFirstWithId($projectId);
        $this->set("name", $project->name);
        $this->set("project_path", Ntentan::getUrl($project->machine_name));
        if($project->initialized == 0)
        {
            $this->view->template = "first_run.tpl.php";
            $this->append("section", " :: {$project->name}");
            
            if($_POST["form_submitted"] == "yes")
            {
                $role = new \kakalika\roles\RolesModel();
                $role->name = "Project Members";
                $role->project_id = $projectId;
                $roleId = $role->save();
                
                foreach($_POST["user_ids"] as $userId)
                {
                    $roleUser = new \kakalika\role_users\RoleUsersModel();
                    $roleUser->user_id = $userId;
                    $roleUser->role_id = $roleId;
                    $roleUser->save();
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
