<?php

namespace kakalika\modules\issues;
use kakalika\modules\updates\Updates;

class IssuesController extends \kakalika\lib\KakalikaController
{
    private $project;
    
    public function init()
    {
        parent::init();
        $this->set('sub_section', 'Issues');
        
        if($GLOBALS["ROUTE_MODE"] == 'project')
        {
            $this->project = \kakalika\modules\projects\Projects::getJustFirstWithCode($GLOBALS['ROUTE_PROJECT_CODE']);
            
            $this->set('project_name', $this->project->name);
            $this->set('project_code', $this->project->code);
            $this->set('sub_section_menu', 
                array(
                    array(
                        'label' => 'Create A New Issue',
                        'url' => \ntentan\Ntentan::getUrl("{$this->project->code}/issues/create"),
                        'id' => 'menu-item-issues-create'
                    )
                )
            );
            
            if($this->project->count() == 0)
            {
                throw new \ntentan\exceptions\RouteNotAvailableException();
            }
        }   
    }
    
    public function close($issueId)
    {
        
    }
    
    public function show($issueId)
    {
        $issue = $this->model->getFirst(
            array(
                'conditions' => array(
                    'number' => $issueId,
                    'project_id' => $this->project->id
                )
            )
        ); 
            
        if(isset($_POST['comment']))
        {
            // @todo Move this section to the issues model
            $update = Updates::getNew();
            if($_POST['action'] == 'Resolve') $update->status = 'RESOLVED';
            elseif($_POST['action'] == 'Close') $update->status = 'CLOSED';
            elseif($_POST['action'] == 'Reopen') $update->status = 'REOPENED';
            
            $update->comment = $_POST['comment'];
            $update->issue_id = $issue->id;
            $update->save();
            
            $updatedIssue = $this->model->getNew();
            $updatedIssue->id = $issue->id;
            $updatedIssue->status = $update->status;
            $updatedIssue->update();
            
            \ntentan\Ntentan::redirect(\ntentan\Ntentan::$requestedRoute);
        }
        else
        {       
            $this->set('issue', $issue->toArray());
        }
    }
    
    public function run()
    {
        $issues = Issues::getAllWithProjectId(
            $this->project->id,
            array(
                'sort' => 'id DESC'
            )
        );
        $this->set('issues', $issues);
    }
    
    public function edit($issueId)
    {
        $issue = Issues::getJustFirst(
            array(
                'conditions' => array(
                    'project_id' => $this->project->id,
                    'number' => $issueId
                )
            )
        );
        if(isset($_POST['title']))
        {            
            $issue->setData($_POST);
            $issue->update();
            \ntentan\Ntentan::redirect("{$this->project->code}/issues/$issueId");
        }
        else
        {
            $this->set('form_data', $issue->toArray());
            $this->setupAssignees();
        }
    }
    
    public function create()
    {
        if(isset($_POST['title']))
        {
            $this->set('form_data', $_POST);
            $newIssue = Issues::getNew();
            $newIssue->setData($_POST);
            $newIssue->project_id = $this->project->id;
            $saved = $newIssue->save();
            
            if($saved !== false)
            {
                \ntentan\Ntentan::redirect("{$this->project->code}/issues");
            }
        }
        
        $this->setupAssignees();
    }
    
    private function setupAssignees()
    {
        $users = \kakalika\modules\user_projects\UserProjects::getAllWithProjectId(
            $this->project->id,
            array(
                'fields' => array(
                    'id',
                    'user.id',
                    'user.firstname',
                    'user.lastname'
                )
            )
        );
        $assignees = array();
        
        foreach($users as $user)
        {
            $assignees[$user['user']['id']] = "{$user['user']['firstname']} {$user['user']['lastname']}";
        }
        
        $this->set('assignees', $assignees);        
    }
}
