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
        $this->set("section", "Users");
        $this->addComponent("admin");
        
        switch($this->method)
        {
            case "page":
            case "run":
                $this->subMenuBlock->addItem(
                    array(
                        "label" => "Add a new user",
                        "path"  => "users/add"
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
    
    /*public function page($pageNumber)
    {
        $itemsPerPage = 10;
        $this->view->layout->addJavaScript("/resources/js/main.js");
        $model = new UsersModel();
        $data = $model->get($itemsPerPage, array("offset"=>($pageNumber-1) * $itemsPerPage));
        $count = $model->get('count');
        $this->set("users", $data->getData());
        $numPages = ceil($count / $itemsPerPage);
        $pagingLinks = array();
        
        if($count > $itemsPerPage)
        {
            if($pageNumber > 1)
            {
                $pagingLinks[] = array(
                    "link" => Ntentan::getUrl("users/page/" . $i - 1),
                    "label" => "< Prev"
                );
            }
                    
            for($i = 1; $i <= $numPages; $i++)
            {
                $pagingLinks[] = array( 
                    "link" => Ntentan::getUrl("users/page/$i"),
                    "label" => "$i"
                );
            }
            
            if($pageNumber < $numPages)
            {
                $pagingLinks[] = array(
                    "link" => Ntentan::getUrl("users/page/" . $i + 1),
                    "label" => "Next >"
                );
            }
            $this->set("pages", $pagingLinks);
        }
    }
    
    public function run()
    {
        $this->view->template = "kakalika/users/page.tpl.php";
        $this->page(1);
    }*/
    
    public function login()
    {
        $this->layout = "plain";
        $this->layout->addStyleSheet("resources/css/login.css");
    }
    
    /*public function add()
    {
        if(count($_POST) > 0)
        {
            $model = new UsersModel();
            unset($_POST["password_2"]);
            $model->setData($_POST);
            if($model->save())
            {
                Ntentan::redirect(
                    Ntentan::getUrl("users") . "?n=" . 
                    urlencode("Successfully added new user <b>{$model["username"]}</b>")
                );
            }
            else
            {
                $this->set("errors", $model->invalidFields);
            }
        }
    }
    
    public function edit($id)
    {
        $user = UsersModel::getFirstWithId($id);
        $this->set("user_data", $user->getData());
        
        if(count($_POST) > 0)
        {
            $user->setData($_POST);
            if($user->update())
            {
                Ntentan::redirect(
                    Ntentan::getUrl("users") . "?n=" . 
                    urlencode("Successfully updated new user <b>" . $user["username"] . "</b>")
                );
            }
            else
            {
                $this->set('errors', $user->invalidFields);
            }
        }
    }

    public function delete($id)
    {
        $this->view = false;
        $user = UsersModel::getFirstWithId($id);
        $user->delete();
        Ntentan::redirect(
            Ntentan::getUrl("users") . "?n=" . 
            urlencode("Successfully deleted user <b>" . $user["username"] . "</b>")
        );
    }*/
    
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
