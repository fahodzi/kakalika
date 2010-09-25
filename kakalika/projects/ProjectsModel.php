<?php
namespace kakalika\projects;

use ntentan\models\Model;
use ntentan\Ntentan;

Ntentan::addIncludePath("kakalika/roles");
Ntentan::addIncludePath("kakalika/role_users");

class ProjectsModel extends Model
{
    public $hasMany = array(
        "roles"
    );
    public function __toString()
    {
        return $this["name"];
    }
    
    public function postSaveCallback($id)
    {
        $role = new \kakalika\roles\RolesModel();
        $role->project_id = $id;
        $role->name = "Administrator";
        $roleId = $role->save();
        
        $roleUser = new \kakalika\role_users\RoleUsersModel();
        $roleUser->role_id = $roleId;
        $roleUser->user_id = \ntentan\controllers\components\auth\Auth::userId();
        $roleUser->save();
    }
}