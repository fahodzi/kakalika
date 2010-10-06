<?php
namespace kakalika\feed;

use ntentan\controllers\components\auth\Auth;
use kakalika\KakalikaController;
use ntentan\controllers\Controller;
use ntentan\Ntentan;

class FeedController extends KakalikaController
{
    public function run()
    {
        $this->set("section", "Feed");
        $this->set("feed_items", array());
        switch(MODE)
        {
            case "DASHBOARD":
                $this->addBlock("projects");
                $feedItems = $this->model->get(
                    'all',
                    array(
                        "conditions" => array(
                            "user_id" => Auth::userId(),
                        ),
                        "fetch_related" => true
                    )
                );
                $this->set("feed_items", $feedItems->toArray());
                break;
            case "PROJECT":
                $feedItems = $this->model->getAllWithProjectId($this->project->id);
                $this->set("feed_items", $feedItems->toArray());
                break;
        }
    }
}