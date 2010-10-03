<?php

namespace kakalika\feed;

use \kakalika\KakalikaController;
use \ntentan\controllers\Controller;
use \ntentan\Ntentan;

class FeedController extends KakalikaController
{
    public function run()
    {
        $this->set("section", "Feed");
        switch(MODE)
        {
            case "DASHBOARD":
                $this->addBlock("projects");
                break;
            case "PROJECT":
                $feedItems = $this->model->getAllWithProjectId();
                $this->set("feed_items", $feedItems->toArray());
                break;
        }
    }
}