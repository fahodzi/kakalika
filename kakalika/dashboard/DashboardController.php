<?php
namespace kakalika\dashboard;

use ntentan\controllers\Controller;
use ntentan\controllers\components\auth\Auth;
use kakalika\KakalikaController;

require "kakalika/feed/FeedModel.php";

class DashboardController extends KakalikaController
{
    public function init()
    {
        parent::init();
        $this->set("main_section", "Dashboard");
        $this->addBlock("projects");
    }
    
    public function run()
    {
        switch(MODE)
        {
            case "ADMIN":
                $feedItems = \kakalika\feed\FeedModel::getAllWithIsAdmin(true, array("sort"=>"time DESC"));
                $this->set("feed_items", $feedItems->toArray());
                break;
            case "DASHBOARD":
                $feedItems = \kakalika\feed\FeedModel::getAllWithUserId(Auth::userId(), array("sort"=>"time DESC"));
                $this->set('feed_items', $feedItems->toArray());
                break;
            case "PROJECT":
                $feedItems = \kakalika\feed\FeedModel::getAllWithProjectId($this->project->id, array("sort"=>"time DESC"));
                $this->set('feed_items', $feedItems->toArray());
                break;
        }
    }
}