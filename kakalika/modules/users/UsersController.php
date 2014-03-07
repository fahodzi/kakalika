<?php
/**
 * Kakalika's entry point
 * 
 * Ntentan Framework
 * Copyright (c) 2013 James Ekow Abaka Ainooson
 * 
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 * 
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE. 
 * 
 * @author James Ainooson <jainooson@gmail.com>
 * @copyright Copyright 2013 James Ekow Abaka Ainooson
 * @license MIT
 */
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
        
        if($GLOBALS['ROUTE_MODE'] == 'admin' && $_SESSION['user']['is_admin'] == true)
        {      
            $this->set('sub_section_path', 'admin/users');            
            $this->setupCreateIssueButton();
        }
        else if(Ntentan::$requestedRoute != 'account')
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
            $_POST['password'] = md5($_POST['password']);
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
            $user = $this->model->getJustFirstWithUsername($_SESSION['user']['username']);
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
                     if($GLOBALS['ROUTE_MODE'] == 'admin')
                     {
                         Ntentan::redirect(Ntentan::getUrl('admin/users'));
                     }
                     else
                     {
                        $_SESSION['user'] = $user->getData();                         
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
