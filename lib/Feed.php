<?php
namespace kakalika;

use ntentan\models\Model;

class Feed
{
    const ACTIVITY_CREATED_PROJECT = 'CREATED_PROJECT';
    const ACTIVITY_CREATED_USER = 'CREATED_USER';
    const ACTIVITY_USER_ADDED_TO_PROJECT = 'USER_ADDED_TO_PROJECT';
    const ACTIVITY_USER_REMOVED_FROM_PROJECT = 'USER_REMOVED_FROM_PROJECT';

    public static function add($activity, $projectId = null, $data = null)
    {
        $feed = Model::load("feed");
        $feed->activity = $activity;
        $feed->user_id = \ntentan\controllers\components\auth\Auth::userId();
        if($projectId !== null) $feed->project_id = $projectId;
        if($data !== null) $feed->data = $data;
        if(MODE == "ADMIN") $feed->is_admin = true;
        $feed->save();
    }
}
