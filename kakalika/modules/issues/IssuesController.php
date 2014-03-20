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
            if($this->project->count() == 0) throw new \ntentan\exceptions\RouteNotAvailableException();
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
            
            $this->setupCreateIssueButton();
        }   
    }
    
    private function harvestAttachments($issue)
    {
        $valid = true;
        if(count($_FILES['attachment']) > 0)
        {
            foreach($_FILES['attachment']['error'] as $index => $error)
            {
                if($error == UPLOAD_ERR_OK)
                {
                    $destination = uniqid() . "_{$_FILES['attachment']['name'][$index]}";
                    move_uploaded_file($_FILES['attachment']['tmp_name'][$index], "uploads/$destination");
                    $issue->addAttachment(
                        array(
                            'file' => $destination,
                            'name' => $_FILES['attachment']['name'][$index],
                            'size' => $_FILES['attachment']['size'][$index],
                            'type' => $_FILES['attachment']['type'][$index]
                        )
                    );
                }
                else
                {
                    $valid = false;
                }
            }
        }
        return $valid;
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
        $this->set('sub_section_path', "{$this->project->code}/issues");
            
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
            $this->harvestAttachments($updatedIssue);
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
        switch ($_GET['filter'])
        {
            case 'open':
                $filters = array(
                    'status' => array('OPEN', 'REOPENED', 'RESOVED')
                );
                break;
            
            case 'closed':
                $filters = array(
                    'status' => 'CLOSED'
                );
                break;      
            
            case 'resolved':
                $filters = array(
                    'status' => 'RESOLVED'
                );
                break;              
            
            case 'mine':
                $filters = array(
                    'assignee' => $_SESSION['user']['id']
                );                
                break;
            
            case 'reported':
                $filters = array(
                    'opener' => $_SESSION['user']['id']
                );
                break;
            
            case 'unassigned':
                $filters = array(
                    'assignee' => null
                );
                break;            
        }
        
        switch($_GET['sorter'])
        {
            case 'created':
                $sort = 'created desc';
                break;
            case 'kind':
                $sort = 'kind desc';
                break;
            case 'priority':
                $sort = 'priority desc';
                break;
            case 'updated':
            default:
                $sort = 'updated desc';
                break;
        }
        
        $issues = Issues::getAllWithProjectId(
            $this->project->id,
            array(
                'sort' => $sort,
                'conditions' => $filters
            )
        );
        
        $this->set('issues', $issues);
        $this->set('title', "{$this->project->name} issues");
        
        $this->set(
            'filters', 
            array(
                'all' => 'All issues',
                'mine' => 'Issues assigned to me',
                'reported' => 'Issues opened by me',
                'open' => 'All open issues',
                'closed' => 'All closed issues',
                'resolved' => 'All resolved issues',
                'unassigned' => 'Unasigned issues'
            )
        );
        
        $this->set(
            'sorters', 
            array(
                'created' => 'Creation Date',
                'updated' => 'Last updated',
                'kind' => 'Issue kind',
                'priority' => 'Issue priority'
            )
        );
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
            $this->harvestAttachments($issue);
            $issue->update();
            \ntentan\Ntentan::redirect("{$this->project->code}/issues/$issueId");
        }
        else
        {
            $this->set('form_data', $issue->toArray());
            $this->setupOptions();
        }
    }
    
    public function attachment($id)
    {
        $this->view->template = false;
        $this->view->layout = false;
        $attachment = \kakalika\modules\issue_attachments\IssueAttachments::getJustFirstWithId($id);
        $file = "uploads/{$attachment->attachment_file}";
        
        $this->view->setContentType($attachment->type);
        header("Content-Disposition: attachment; filename=\"{$attachment->name}\"");
        
        if(file_exists($file))
        {
            header("Content-Length: {$attachment->size}");
            echo file_get_contents($file);
        }
        else
        {
            header('HTTP/1.0 404 Not Found');
        }
    }
    
    public function create()
    {
        if(isset($_POST['title']))
        {
            $newIssue = Issues::getNew();
            $newIssue->setData($_POST);
            $newIssue->project_id = $this->project->id;
            $this->harvestAttachments($newIssue);            
            
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
        
        if($this->project->id)
        {
            $this->set('title', "Create a new {$this->project->name} issue");
            $this->setupOptions();                 
        }
        else
        {
            $this->set('projects', $this->getUserProjects());
            $this->view->template = 'issues_select_project.tpl.php';
        }
           
    }
    
    private function setupOptions()
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
        
        $components = \kakalika\modules\components\Components::getJustAllWithProjectId($this->project->id);
        $componentsOptions = array();
        foreach($components as $component)
        {
            $componentsOptions[$component->id] = $component->name;
        }
        $this->set('components', $componentsOptions);
        
        $milestones = \kakalika\modules\milestones\Milestones::getJustAllWithProjectId($this->project->id);
        $milestonesOptions = array();
        foreach($milestones as $milestone)
        {
            $milestonesOptions[$milestone->id] = $milestone->name;
        }
         
       $this->set('milestones', $milestonesOptions);
    }
}
