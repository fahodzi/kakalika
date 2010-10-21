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
        
        $this->view->layout->addStyleSheet(Ntentan::getFilePath("views/helpers/forms/stylesheets/forms.css"));
        $this->view->layout->addStyleSheet("resources/css/main.css");
        $this->view->layout->addStyleSheet(Ntentan::getFilePath("stylesheets/ntentan.css"));
        $this->view->layout->addStyleSheet(Ntentan::getFilePath("stylesheets/grid.css"));
        $this->view->layout->title = "Kakalika";
        
        $this->topMenuBlock->addItem(
            array(
                "label" => "Dashboard",
                "path"  => Ntentan::getUrl("dashboard")
            )
        );
        
        if(defined('MODE'))
        {
            switch(MODE)
            {
                case 'ADMIN':
                    $this->topMenuBlock->addItem(
                        array(
                            "label" => "Projects",
                            "url" => Ntentan::getUrl("admin/projects")
                        )
                    );
                    
                    $this->topMenuBlock->addItem(
                        array(
                            "label" => "Users",
                            "url" => Ntentan::getUrl("admin/users")
                        )
                    );
                    $this->set("main_section", "Administration");
                    break;
                case 'PROJECT':
                    $this->project = \kakalika\projects\ProjectsModel::getFirstWithMachineName(PROJECT_NAME);
                    if(isset($this->project["name"]))
                    {
                        $this->set("main_section", $this->project->name);
                        $this->topMenuBlock->addItem(
                            array(
                                "label"=>"Issues",
                                "url" => Ntentan::getUrl($this->project->machine_name . "/issues"),
                            )
                        );
                        $this->topMenuBlock->addItem(
                            array(
                                "label"=>"Pages",
                                "url" => Ntentan::getUrl($this->project->machine_name . "/pages"),
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
                    $profile = \ntentan\controllers\components\auth\Auth::getProfile();
                    if($profile["is_admin"])
                    {
                        $this->topMenuBlock->addItem(
                            array(
                                "label" => "Administration",
                                "url" => Ntentan::getUrl("admin")
                            )
                        );
                    }
                    break;
            }
        }
        $this->topMenuBlock->addItem("Inbox");
    }
}
