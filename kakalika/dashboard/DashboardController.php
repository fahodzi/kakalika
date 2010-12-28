<?php
namespace kakalika\dashboard;

use ntentan\controllers\Controller;
use ntentan\controllers\components\auth\Auth;
use kakalika\KakalikaController;

require "kakalika/feed/Feed.php";

class DashboardController extends KakalikaController
{
    public function init()
    {
        parent::init();
        $this->addWidget("projects");
    }
    
    public function run()
    {
        switch(MODE)
        {
            case "ADMIN":
                $feedItems = \kakalika\feed\Feed::getAllWithIsAdmin(true, array("sort"=>"time DESC"));
                $this->set("feed_items", $feedItems->toArray());
                break;
            case "DASHBOARD":
                $feedItems = \kakalika\feed\Feed::getAllWithUserId(Auth::userId(), array("sort"=>"time DESC"));
                $this->set('feed_items', $feedItems->toArray());
                break;
            case "PROJECT":
                $feedItems = \kakalika\feed\Feed::getAllWithProjectId($this->project->id, array("sort"=>"time DESC"));
                $this->set('feed_items', $feedItems->toArray());
                break;
        }
    }
}