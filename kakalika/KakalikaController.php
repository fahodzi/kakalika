<?php
namespace kakalika;

require "kakalika/projects/ProjectsModel.php";

use ntentan\Ntentan;
use ntentan\controllers\Controller;

class KakalikaController extends Controller
{
    protected $project;
    
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
                    $this->set("main_section", "Administration");
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
                    $this->project = \kakalika\projects\ProjectsModel::getFirstWithMachineName(PROJECT_NAME);
                    if(isset($this->project["name"]))
                    {
                        $this->set("main_section", $this->project->name);
                        $this->topMenuBlock->addItem(
                            array(
                                "label"=>"Feed",
                                "path" => Ntentan::getUrl($this->project->machine_name . "/feed"),
                            )
                        );
                        $this->topMenuBlock->addItem(
                            array(
                                "label"=>"Issues",
                                "path" => Ntentan::getUrl($this->project->machine_name . "/issues"),
                            )
                        );
                        $this->topMenuBlock->addItem(
                            array(
                                "label"=>"Pages",
                                "path" => Ntentan::getUrl($this->project->machine_name . "/pages"),
                            )
                        );
                    }
                    else if($this->project["name"] == "")
                    {
                        
                    }
                    else
                    {
                        $this->notFound();
                    }
                    break;
                case "DASHBOARD":
                    $this->set("main_section", "Dashboard");
                    $this->topMenuBlock->addItem(
                        array(
                            "label" => "Feed",
                            "path" => Ntentan::getUrl("feed")
                        )
                    );
                    $profile = \ntentan\controllers\components\auth\Auth::getProfile();
                    if($profile["is_admin"])
                    {
                        $this->topMenuBlock->addItem(
                            array(
                                "label" => "Administration",
                                "path" => Ntentan::getUrl("admin")
                            )
                        );
                    }
                    break;
            }
        }
        $this->topMenuBlock->addItem("Inbox");
    }
}
