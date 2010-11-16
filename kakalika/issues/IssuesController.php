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
            'created',
            'last_updated',
            'assigned_to',
            'type',
            'priority',
            'id'
        );
        $this->adminComponent->hasAddOperation = false;
        $this->adminComponent->hasEditOperation = false;
        $this->adminComponent->itemOperationUrl = Ntentan::getUrl(Ntentan::$requestedRoute);
        $this->adminComponent->rowTemplate = "row.tpl.php";
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

    public function view($issueId)
    {
        $projectUsers = \kakalika\project_users\ProjectUsers::getAllWithProjectId($this->project->id);
        $this->set("project_users", $projectUsers->toArray());
        $issue = $this->model->getFirstWithId($issueId);
        $this->set("issue", $issue->toArray());
        $this->set("sub_section", $issue->title);
    }
    
    public function add()
    {
        $this->set("sub_section", "Report a new Issue");
        $projectUsers = \kakalika\project_users\ProjectUsers::getAllWithProjectId($this->project->id);
        $this->set("project_users", $projectUsers->toArray());
        if(isset($_POST["title"]))
        {
            $issue = $this->model;
            $issue->setData($_POST);
            $issue->project_id = $this->project->id;
            $issue->created_by = Auth::userId();
            $issue->status = 'New';
            $issue->created = date('Y-m-d H:i:s', time());
            $issue->last_updated = date('Y-m-d H:i:s', time());
            $id = $issue->save();
            if($id === false)
            {
                $this->set("errors", $issue->invalidFields);
            }
            else
            {
                Ntentan::redirect($this->project->machine_name . "/issues");
            }
        }
    }
}
