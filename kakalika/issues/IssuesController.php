<?php
namespace kakalika\issues;

use kakalika\KakalikaController;
use ntentan\controllers\Controller;

class IssuesController extends KakalikaController
{
    public function run()
    {
        $this->addBlock("menu", "issues_menu");
        $this->issuesMenuBlock->addItem(
            array(
                "label" => "Add a new issue",
                "path"  => "issues/new"
            )
        );
        
        $this->issuesMenuBlock->addItem(
            array(
                "label" => "Search Issues",
                "path"  => "issues/search"
            )
        );
        
        $this->set("section", "Issues");
    }
}
