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
    }
}