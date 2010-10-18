<?php
namespace kakalika\dashboard;

use ntentan\controllers\Controller;
use kakalika\KakalikaController;

require "kakalika/feed/FeedModel.php";

class DashboardController extends KakalikaController
{
    public function init()
    {
        parent::init();
        $this->set("main_section", "Dashboard");
        $this->set("section", "Feed");
    }
    
    public function run()
    {
        switch(MODE)
        {
            case "ADMIN":
                $feedItems = \kakalika\feed\FeedModel::getAllWithIsAdmin(true, array("sort"=>"time DESC"));
                $this->set("feed_items", $feedItems->toArray());
                break;
        }
    }
}