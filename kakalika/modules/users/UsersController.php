<?php
namespace kakalika\modules\users;

use kakalika\lib\KakalikaController;
use ntentan\Ntentan;

class UsersController extends KakalikaController
{
    public function init()
    {
        parent::init();
        $this->set('sub_section', 'Users');    
        $this->set('title', 'Users');
        
        if($GLOBALS['ROUTE_MODE'] == 'admin')
        {
            $this->set('sub_section_menu', 
                array(
                    array(
                        'label' => 'Add a new uesr',
                        'url' => \ntentan\Ntentan::getUrl("admin/users/add"),
                        'id' => 'menu-item-users-add'
                    )
                )
            );        
            $this->set('sub_section_path', 'admin/users');            
        }
        else
        {
            throw new \ntentan\exceptions\RouteNotAvailableException();
        }
    }
    
    public function block($id)
    {
        $user = $this->model->getJustFirstWithId($id);
        $this->set('title', "Block user $user");
        
        if($_GET['confirm'] == 'yes')
        {
            $user->blocked = true;
            $user->update();
            Ntentan::redirect(Ntentan::getUrl("admin/users"));
        }
        
        $this->set(
            array(
                'name' => "{$user->firstname} {$user->lastname}",
            )
        );
    }
    
    public function run()
    {
        $users = $this->model->getAll(
            array(
                'fields' => array('firstname', 'lastname', 'username', 'email', 'id')
            )
        );
        $this->set('users', $users->toArray());
    }
    
    public function add()
    {
        $this->set('title', 'Add an new user');
            
        if(isset($_POST['firstname']))
        {
            $errors = array();
            $user = $this->model->getNew();
            
            if($_POST['password'] != $_POST['repeat_password'])
            {
                $errors['repeat_password'] = array('Passwords entered do not match');
            }     
            unset($_POST['repeat_password']);            
            $user->setData($_POST);
            
            if(count($errors) == 0)
            {
                if($user->save())
                {
                    Ntentan::redirect(Ntentan::getUrl('admin/users'));
                }
            }
            
            $errors = array_merge($errors, $user->invalidFields);
            
            $this->set('errors', $errors);
            $this->set('user', $_POST);
        }
    }

    public function edit($id = false)
    {                
        if(is_numeric($id))
        {
            $user = $this->model->getJustFirstWithId($id);
        }
        else 
        {
            $user = $this->model->getJustFirstWithUsername($id);
        }
        
        if($GLOBALS['ROUTE_MODE'] == 'admin')
        {
            $this->set('admin', true);
            $this->set('sub_section', 'Users');  
            $this->set('title', "Edit user {$user}");
        }
        else
        {
            $this->set('sub_section', 'Account');            
            if($id === false) $id = $_SESSION['user']['username'];
            $this->set('title', 'My Account');
        }          
        
        if(isset($_POST['firstname']))
        {   
            $errors = array();
            
            if($GLOBALS['ROUTE_MODE'] == 'admin')
            {
                if($_POST['new_password'] != '')
                {
                    if($_POST['new_password'] == $_POST['repeat_new_password'] && $_POST['new_password'] != '')
                    {
                        $_POST['password'] = md5($_POST['new_password']);
                        unset($_POST['new_password']);
                        unset($_POST['repeat_new_password']);
                    }
                    else
                    {
                        $errors['new_password'] = array('Your new passwords do not match');
                    }                
                }
            }
            else
            {
                if($_POST['current_password'] != '')
                {
                    if($user->password == md5($_POST['current_password']))
                    {
                        if($_POST['new_password'] == $_POST['repeat_new_password'] && $_POST['new_password'] != '')
                        {
                            $_POST['password'] = md5($_POST['new_password']);
                            unset($_POST['new_password']);
                            unset($_POST['repeat_new_password']);
                            unset($_POST['current_password']);
                        }
                        else
                        {
                            $errors['new_password'] = array('Your new passwords do not match');
                        }
                    }
                    else
                    {
                        $errors['current_password'] = array("The password you entered is invalid");
                    }
                }
            }
            
            $this->set('user', $_POST);
            $user->setData($_POST);
            
            if(count($errors) == 0)
            {
                if($user->update())
                {
                     $_SESSION['user'] = $user->getData();
                     if($GLOBALS['ROUTE_MODE'] == 'admin')
                     {
                         Ntentan::redirect(Ntentan::getUrl('admin/users'));
                     }
                }
            }
            
            $errors = array_merge($errors, $user->invalidFields);
            $this->set('errors', $errors);
        }
        else
        {
            $this->set('user', $user->toArray());            
        }        
    }
}
