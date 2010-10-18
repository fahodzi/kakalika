<?php
namespace kakalika\role_users;

use ntentan\models\Model;
use kakalika\Feed;
use kakalika\roles\RolesModel;
use kakalika\users\UsersModel;

class RoleUsersModel extends Model
{
    public function postSaveCallback($id)
    {
        $role = RolesModel::getFirstWithId($this->role_id);
        $user = UsersModel::getFirstWithId($this->user_id);
        $data = json_encode(
            array(
                "role"=>$role->toArray(), 
                "user"=>$user->toArray()
            )
        );
        Feed::add(
            Feed::ACTIVITY_USER_ADDED_TO_PROJECT,
            $role["project_id"],
            $data
        );
    }
}
