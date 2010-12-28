<?php
namespace kakalika;

require "kakalika/projects/Projects.php";

use ntentan\Ntentan;
use ntentan\controllers\Controller;
use \Exception;

class KakalikaController extends Controller
{
    protected $project;
    
    public function init()
    {
        $this->addComponent("auth");
        
        $this->addWidget("menu", "top_menu");
        $this->addWidget("login_info");
        $this->addWidget("menu", "sub_menu");
        
        $this->view->layout->addStyleSheet(Ntentan::getFilePath("lib/views/helpers/forms/css/forms.css"));
        $this->view->layout->addStyleSheet("resources/css/main.css");
        //$this->view->layout->addStyleSheet(Ntentan::getFilePath("stylesheets/ntentan.css"));
        $this->view->layout->addStyleSheet(Ntentan::getFilePath("css/grid.css"));
        $this->view->layout->addJavaScript(Ntentan::getFilePath("js/jquery.js"));
        $this->view->layout->title = "Kakalika";
        
        $this->topMenuWidget->addItem(
            array(
                "label" => "Dashboard",
                "url"  => Ntentan::getUrl("dashboard")
            )
        );
        
        if(defined('MODE'))
        {
            switch(MODE)
            {
                case 'ADMIN':
                    $this->topMenuWidget->addItem(
                        array(
                            "label" => "Projects",
                            "url" => Ntentan::getUrl("admin/projects")
                        )
                    );
                    
                    $this->topMenuWidget->addItem(
                        array(
                            "label" => "Users",
                            "url" => Ntentan::getUrl("admin/users")
                        )
                    );
                    $this->set("main_section", "Administration");
                    break;
                case 'PROJECT':
                    $this->project = \kakalika\projects\Projects::getFirstWithMachineName(PROJECT_NAME);
                    if(isset($this->project["name"]))
                    {
                        $this->set("main_section", $this->project->name);
                        $this->topMenuWidget->addItem(
                            array(
                                "label"=>"Issues",
                                "url" => Ntentan::getUrl($this->project->machine_name . "/issues"),
                            )
                        );
                        $this->topMenuWidget->addItem(
                            array(
                                "label"=>"Pages",
                                "url" => Ntentan::getUrl($this->project->machine_name . "/pages"),
                            )
                        );
                    }
                    else if($this->project["name"] == "")
                    {
                        throw new Exception("Project not found");
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
                        $this->topMenuWidget->addItem(
                            array(
                                "label" => "Administration",
                                "url" => Ntentan::getUrl("admin")
                            )
                        );
                    }
                    break;
            }
        }
        $this->topMenuWidget->addItem("Inbox");
    }
}
