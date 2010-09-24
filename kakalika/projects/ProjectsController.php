<?php
namespace kakalika\projects;

use kakalika\KakalikaController;
use ntentan\Ntentan;

class ProjectsController extends KakalikaController
{
    public function init()
    {
        parent::init();
        $this->addComponent("admin");
        $this->adminComponent->postAddCallback = "routeProjectSetup";
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
                        "path"  => "projects/add"
                    )
                );
                break;
        }
    }
    
    public function routeProjectSetup($id, $project)
    {
        Ntentan::redirect(Ntentan::getUrl("projects/setup/$id"));
    }
    
    public function setup($projectId)
    {
        $project = $this->model->getFirstWithId($projectId);
        if($project->initialized == 0)
        {
            $this->append("section", " • {$project->name}");
            $this->view->template = "first_run.tpl.php";
        }
    }
}
