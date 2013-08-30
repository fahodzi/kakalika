<?php
namespace kakalika\modules\users;

use kakalika\lib\KakalikaController;

class UsersController extends KakalikaController
{
    public function init()
    {
        parent::init();
        $this->set('sub_section', 'Users');      
        $this->set('sub_section_menu', 
            array(
                array(
                    'label' => 'Add a User',
                    'url' => \ntentan\Ntentan::getUrl("admin/users/add"),
                    'id' => 'menu-item-users-add'
                )
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
    
    public function edit($id = false)
    {
        $this->set('sub_section', 'Account');
        
        if($GLOBALS['ROUTE_MODE'] == 'admin')
        {
            $this->set('admin', true);
        }
        
        if($id === false) $id = $_SESSION['user']['username'];
        if(is_numeric($id))
        {
            $user = $this->model->getJustFirstWithId($id);
        }
        else 
        {
            $user = $this->model->getJustFirstWithUsername($id);
        }
        
        if(isset($_POST['firstname']))
        {
            $this->set('user', $_POST);
            $user->setData($_POST);
            if($user->update())
            {
                 $_SESSION['user'] = $user->getData();
            }
            else
            {
                $this->set('errors', $user->invalidFields);
            }
        }
        else
        {
            $this->set('user', $user->toArray());            
        }
    }
}
