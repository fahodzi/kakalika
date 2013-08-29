<?php
namespace kakalika\modules\users;

use kakalika\lib\KakalikaController;

class UsersController extends KakalikaController
{
    public function init()
    {
        parent::init();
        $this->set('sub_section', 'Account');
    }
    
    public function edit($id = false)
    {
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
