<?php
namespace kakalika\modules\issues;

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
        
        $status = $issue->status;
        $this->set('title', "[#{$issue['number']}] {$issue['title']}");        
            
        if(isset($_POST['comment']))
        {
            if($_POST['action'] == 'Resolve') $status = 'RESOLVED';
            elseif($_POST['action'] == 'Close') $status = 'CLOSED';
            elseif($_POST['action'] == 'Reopen') $status = 'REOPENED';
                        
            $updatedIssue = $this->model->getNew();
            $updatedIssue->id = $issue->id;
            $updatedIssue->status = $status;
            $updatedIssue->comment = $_POST['comment'];
            $updatedIssue->number_of_updates = $issue->number_of_updates;
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
        $this->set('title', "{$this->project->name} issues");
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
        $this->set('title', "Edit Issue #{$issue['number']} {$issue['title']}");
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
            $newIssue = Issues::getNew();
            $newIssue->setData($_POST);
            $newIssue->project_id = $this->project->id;
            if($newIssue->save())
            {
                \ntentan\Ntentan::redirect("{$this->project->code}/issues");
            }
            else 
            {
                $this->set(
                    array(
                        'data' => $_POST,
                        'errors' => $newIssue->invalidFields
                    )
                );
            }
        }
        $this->set('title', "Create a new {$this->project->name} issue");
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
