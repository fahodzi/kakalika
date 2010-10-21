<?php
namespace kakalika\issues;

use kakalika\KakalikaController;
use ntentan\Ntentan;
use ntentan\controllers\Controller;

class IssuesController extends KakalikaController
{
    public function init()
    {
        parent::init();
        $this->addComponent("admin");
        $this->adminComponent->prefix = PROJECT_NAME;
        $this->set("section", "Issues");
        switch($this->method)
        {
            case "page":
            case "run":
                $this->subMenuBlock->addItem(
                    array(
                        "label" => "Create Issue",
                        "url"  => Ntentan::getUrl(PROJECT_NAME . "/issues/add")
                    )
                );
                break;
        }        
    }
    public function run()
    {
        $this->set("section", "Issues");
    }
}
