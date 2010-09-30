<?php
namespace kakalika;

require "kakalika/projects/ProjectsModel.php";

use ntentan\Ntentan;
use ntentan\controllers\Controller;

class KakalikaController extends Controller
{
    public function init()
    {
        $this->addComponent("auth");
        $this->addBlock("menu", "top_menu");
        $this->addBlock("login_info");
        
        $this->addBlock("menu", "sub_menu");
        
        $this->view->layout->addStyleSheet(Ntentan::getFilePath("views/helpers/forms/css/form.css"));
        $this->view->layout->addStyleSheet("resources/css/main.css");
        $this->view->layout->addStyleSheet("resources/css/grid.css");
        $this->view->layout->title = "Kakalika";
        
        if(defined('MODE'))
        {
            switch(MODE)
            {
                case 'ADMIN':
                    $this->topMenuBlock->addItem(
                        array(
                            "label"=>"Feed",
                            "path" => Ntentan::getUrl("admin/feed"),
                        )
                    );
                    $this->topMenuBlock->addItem(
                        array(
                            "label" => "Projects",
                            "path" => Ntentan::getUrl("admin/projects")
                        )
                    );
                    
                    $this->topMenuBlock->addItem(
                        array(
                            "label" => "Users",
                            "path" => Ntentan::getUrl("admin/users")
                        )
                    );
                    break;
                case 'PROJECT':
                    $project = \kakalika\projects\ProjectsModel::getFirstWithMachineName(PROJECT_NAME);
                    if(isset($project["name"]))
                    {
                        $this->set("main_section", $project->name);
                        $this->topMenuBlock->addItem(
                            array(
                                "label"=>"Feed",
                                "path" => Ntentan::getUrl($project->machine_name . "/feed"),
                            )
                        );
                        $this->topMenuBlock->addItem(
                            array(
                                "label"=>"Issues",
                                "path" => Ntentan::getUrl($project->machine_name . "/issues"),
                            )
                        );
                        $this->topMenuBlock->addItem(
                            array(
                                "label"=>"Pages",
                                "path" => Ntentan::getUrl($project->machine_name . "/pages"),
                            )
                        );
                    }
                    else
                    {
                        $this->notFound();
                    }
                    break;
            }
        }
            
        $this->topMenuBlock->addItem("Inbox");
    }
}
