<?php
namespace kakalika\projects;

use kakalika\KakalikaController;

class ProjectsController extends KakalikaController
{
    public function init()
    {
        $this->addComponent("admin");
        $this->adminComponent->postAddCallback = "setupProject";
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
    
    public function setupProject($id, $project)
    {
        var_dump($id);
        die();
    }
    
    public function initialize($project)
    {
        
    }
}
