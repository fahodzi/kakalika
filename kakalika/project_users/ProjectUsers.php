<?php
namespace kakalika\project_users;

use kakalika\Feed;
use kakalika\users\UsersModel;
use ntentan\models\Model;

class ProjectUsers extends Model
{
    public $belongsTo = array("user", "project");

    public function postSaveCallback($id)
    {
        $user = \kakalika\users\Users::getFirstWithId($this->user_id);
        Feed::add(
            Feed::ACTIVITY_USER_ADDED_TO_PROJECT, 
            $this->project_id, 
            json_encode($user->toArray())
        );
    }
    
    public function preDeleteCallback()
    {
        $user = Users::getFirstWithId($this->user_id);
        Feed::add(
            Feed::ACTIVITY_USER_REMOVED_FROM_PROJECT,
            $this->project_id,
            json_encode($user->toArray())
        );
    }
}
