<?php
namespace kakalika\projects;

use kakalika\permissions\PermissionsModel;

use kakalika\users\UsersModel;
use kakalika\KakalikaController;
use kakalika\roles\RolesModel;
use ntentan\Ntentan;
use ntentan\controllers\components\auth\Auth;
use ntentan\models\Model;

include "kakalika/users/UsersModel.php";
include "kakalika/roles/RolesModel.php";

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
                "label"     => "Setup",
                "operation" => "setup"
            )
        );
        
        $this->adminComponent->addOperation(
            array(
                "label"     => "Roles",
                "operation" => "roles"
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
    
    public function roles($projectId)
    {
        $this->view->template = "roles.tpl.php";
        $this->addBlock("menu", "roles_menu");
        $roles = RolesModel::getAllWithProjectId($projectId);
        $this->rolesMenuBlock->addItem("Add New Role");
        $this->set("roles", $roles->toArray());
        $this->set("permission_groups", PermissionsModel::$permissionGroups);
    }
    
    public function setup($projectId, $subSection = null)
    {
        $project = ProjectsModel::getFirstWithId($projectId);
        $this->set("project", $project);
        $this->addBlock("menu", "setup_menu");
        $this->setupMenuBlock->addItem(
            array(
                "label" => "Roles", 
                "url" => Ntentan::getUrl("admin/projects/setup/{$projectId}/roles")
            )
        );
        $this->setupMenuBlock->addItem(
            array(
                "label" => "Members",
                "url" => Ntentan::getUrl("admin/projects/setup/{$projectId}/members")
            )
        );
        $this->setupMenuBlock->addItem(
            array(
                "label" => "Issue Settings",
                "url" => Ntentan::getUrl("admin/projects/setup/{$projectId}/issue_settings")
            )
        );
        
        switch($subSection)
        {
            case "roles":
                $this->roles($projectId);
                break;
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
