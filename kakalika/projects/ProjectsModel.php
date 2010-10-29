<?php
namespace kakalika\projects;

use ntentan\controllers\components\auth\Auth;

use ntentan\models\Model;
use ntentan\Ntentan;
use kakalika\Feed;

Ntentan::addIncludePath("kakalika/project_users");

class ProjectsModel extends Model
{
    public $hasMany = array(
        "project_users"
    );
    
    public function __toString()
    {
        return $this["name"];
    }
    
    public function postSaveCallback($id)
    {
        Feed::add(Feed::ACTIVITY_CREATED_PROJECT, $id);
        $projectUser = new \kakalika\project_users\ProjectUsersModel();
        $projectUser->is_admin = true;
        $projectUser->project_id = $id;
        $projectUser->user_id = Auth::userId();
        $projectUser->save();
    }
}
