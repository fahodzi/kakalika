<?php
namespace kakalika\users;

use ntentan\Ntentan;

use \kakalika\KakalikaController;
use \ntentan\controllers\Controller;
use \ntentan\models\Model;

class UsersController extends KakalikaController
{
    public function init()
    {
        parent::init();
        $this->set("section", "Users");
        $this->addComponent("admin");
        $this->adminComponent->headings = false;
        $this->adminComponent->notifications = false;
        $this->adminComponent->prefix = "admin";
        
        switch($this->method)
        {
            case "page":
            case "run":
                $this->subMenuBlock->addItem(
                    array(
                        "label" => "Add a new user",
                        "url"  => u("admin/users/add")
                    )
                );
                
                $this->adminComponent->listFields = array(
                    "full_name",
                    "username",
                    "email"
                );
                break;
        }

        $this->adminComponent->addOperation(
            array(
                "label" => "Reset Password",
                "operation" => "reset_password",
                "confirm_message" => "Do you really want to reset the password for %item% ?"
            )
        );
    }
    
    public function login()
    {
        $this->layout = "plain";
        $this->layout->addStyleSheet("resources/css/login.css");
    }
    
    public function reset_password($id)
    {
        $this->view = false;
        $user = UsersModel::getFirstWithId($id);
        $user->resetPassword();
        Ntentan::redirect(
            Ntentan::getUrl("users") . "?n=" . 
            urlencode("Successfully reset user password <b>" . $user["username"] . "</b>")
        );        
    }
}
