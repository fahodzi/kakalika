<?php
namespace kakalika\issues;

use ntentan\controllers\components\auth\Auth;

use kakalika\project_users\ProjectUsersModel;
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
        $this->adminComponent->headings = false;
        $this->adminComponent->notifications = false;
        $this->adminComponent->listFields = array(
            'status',
            'title',
            'created_by',
            'assigned_to',
            'type',
            'priority',
            'id'
        );
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
    
    public function add()
    {
        $projectUsers = \kakalika\project_users\ProjectUsers::getAllWithProjectId($this->project->id);
        $this->set("sub_section", "Report a new Issue");
        $this->set("project_users", $projectUsers->toArray());
        if(isset($_POST["title"]))
        {
            $issue = $this->model;
            $issue->setData($_POST);
            $issue->project_id = $this->project->id;
            $issue->created_by = Auth::userId();
            $issue->status = 'New';
            $id = $issue->save();
            if($id === false)
            {
                $this->set("errors", $issue->invalidFields);
                var_dump($issue->invalidFields);
            }
            else
            {
                Ntentan::redirect($this->project->machine_name . "/issues");
            }
        }
    }
}
