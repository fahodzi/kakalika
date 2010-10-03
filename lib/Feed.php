<?php
use ntentan\models\Model;

class Feed
{
    const ACTIVITY_CREATED_PROJECT = 'CREATED_PROJECT';
    const ACTIVITY_CREATED_USER = 'CREATED_USER';

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
