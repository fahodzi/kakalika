<?php
namespace kakalika;

use ntentan\Ntentan;
use ntentan\controllers\Controller;

class KakalikaController extends Controller
{
    public function init()
    {
        $this->addComponent("auth");
        $this->addBlock("menu", "top_menu");
        
        $this->topMenuBlock->addItem(
            array(
                "label"=>"Feed",
                "path" => Ntentan::getUrl("feed"),
            )
        );
        $this->topMenuBlock->addItem(
            array(
                "label" => "Projects",
                "path" => Ntentan::getUrl("projects")
            )
        );
        
        $this->topMenuBlock->addItem("Users");
        $this->topMenuBlock->addItem("Inbox");
        
        $this->addBlock("menu", "sub_menu");
        
        $this->view->layout->addStyleSheet(Ntentan::getFilePath("views/helpers/forms/css/form.css"));
        $this->view->layout->addStyleSheet("resources/css/main.css");
        $this->view->layout->addStyleSheet("resources/css/grid.css");
        $this->view->layout->title = "Kakalika Issue Tracker";
    }
}
