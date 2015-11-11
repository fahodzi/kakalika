<?php
namespace kakalika\modules\issues;

use ntentan\Router;
use ntentan\utils\Input;
use ntentan\Session;
use kakalika\modules\watchers\Watchers;
use ntentan\Ntentan;

class IssuesController extends \kakalika\lib\KakalikaController
{
    private $project;
    
    public function init()
    {
        parent::init();
        $this->setDefaultMethod('page');
        $this->set('sub_section', 'Issues');
        
        if(Router::getVar("MODE") === 'project')
        {
            $this->project = \kakalika\modules\projects\Projects::fetchFirstWithCode(Router::getVar('PROJECT_CODE'));
            if($this->project->count() == 0) { 
                throw new \ntentan\exceptions\RouteNotAvailableException();
            }
            $this->set('project_name', $this->project->name);
            $this->set('project_code', $this->project->code);
            $this->set('sub_section_menu', 
                [
                    [
                        'label' => 'Create A New Issue',
                        'url' => Ntentan::getUrl("{$this->project->code}/issues/create"),
                        'id' => 'menu-item-issues-create'
                    ]
                ]
            );
            $this->setupCreateIssueButton();
        }   
    }
    
    private function harvestAttachments($issue)
    {
        $files = Input::files('attachment');
        $valid = true;
        if(count($files) > 0)
        {
            foreach($files as $file)
            {
                if($file->getError() === UPLOAD_ERR_OK)
                {
                    $destination = uniqid() . "_{$file->getClientName()}";
                    $file->moveTo("uploads/$destination");
                    $issue->addAttachment(
                        array(
                            'file' => $destination,
                            'name' => $file->getClientName(),
                            'size' => $file->getSize(),
                            'type' => $file->getType()
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
    
    public function watch($issueId)
    {
        $this->view->setTemplate(false);
        $watching = Watchers::getJustFirst(
            array(
                'conditions' => array(
                    'user_id' => $_SESSION['user']['id'],
                    'issue_id' => $issueId
                )
            )
        );
        if($watching->count() == 0)
        {
            $watching = Watchers::getNew();
            $watching->issue_id = $issueId;
            $watching->user_id = $_SESSION['user']['id'];
            $watching->save();
        }
        else
        {
            $watching->delete();
        }
        \ntentan\Ntentan::redirect();
    }
    
    public function show($issueId)
    {
        $issue = Issues::filterByNumber($issueId)->filterByProjectId($this->project->id)->fetchFirst();
        
        $status = $issue->status;
        $this->set('title', "[#{$issue['number']}] {$issue['title']}");        
        $this->set('sub_section_path', "{$this->project->code}/issues");
            
        if(Input::exists(Input::POST, 'comment'))
        {
            if(Input::post('action') == 'Resolve') {
                $status = 'RESOLVED';
            }
            elseif(Input::post('action') == 'Close') {
                $status = 'CLOSED';
            }
            elseif(Input::post('action') == 'Reopen') {
                $status = 'REOPENED';
            }
                        
            $updatedIssue = Issues::fetchFirstWithId($issue->id);
            $updatedIssue->status = $status;
            $updatedIssue->comment = Input::post('comment');
            $updatedIssue->number_of_updates = $issue->number_of_updates;
            $this->harvestAttachments($updatedIssue);
            $updatedIssue->save();
            
            \ntentan\Ntentan::redirect(Router::getRequestedRoute());
        }
        else
        {
            $watching = Watchers::filterByUserId(Session::get('user')['id'])
                ->filterByIssueId($issue->id)
                ->count();
            $this->set('watching', $watching);
            $this->set('issue', $issue);
        }
    }
    
    public function page()
    {
        $issues = Issues::filterByProjectId($this->project->id);

        switch (Input::get('filter'))
        {
            case 'open':
                $issues->filterByStatus('OPEN', 'REOPENED', 'RESOVED');
                break;
            
            case 'closed':
                $issues->filterByStatus('CLOSED');
                break;      
            
            case 'resolved':
                $issues->filterByStatus('RESOLVED');
                break;              
            
            case 'mine':
                $issues->filterByAssignee(Session::get('user')['id']);
                break;
            
            case 'reported':
                $issues->filterByOpener(Session::get('user')['id']);
                break;
            
            case 'unassigned':
                $issues->filterByAssignee(null);
                break;            
        }
        
        switch(Input::get('sorter'))
        {
            case 'created':
                $issues->sortDescByCreated();
                break;
            case 'kind':
                $issues->sortDescByKind();
                break;
            case 'priority':
                $issues->sortDescByPriority();
                break;
            case 'updated':
            default:
                $issues->sortDescByUpdated();
                break;
        }
        $page = Input::exists(Input::GET, 'page') ? Input::get('page') : 1;
        
        $numIssues = Issues::filterByProjectId($this->project->id)->count();
        $numPages = ceil($numIssues / 15);
        $this->set('number_of_pages', $numPages);
        $this->set('base_route', "{$this->project->code}"); 

        
        $issues->limit(15)
            ->offset(($page - 1) * 15)
            ->fetch();
        
        $this->set([
            'sorter' => Input::get('sorter'),
            'filter' => Input::get('filter'),
            'page_number' => $page,
            'filters' => [
                'all' => 'All issues',
                'mine' => 'Issues assigned to me',
                'reported' => 'Issues opened by me',
                'open' => 'All open issues',
                'closed' => 'All closed issues',
                'resolved' => 'All resolved issues',
                'unassigned' => 'Unasigned issues'
            ],
            'issues' => $issues,
            'title' => "{$this->project->name} issues",
            'sorters' => [
                'created' => 'Creation Date',
                'updated' => 'Last updated',
                'kind' => 'Issue kind',
                'priority' => 'Issue priority'
            ]                        
        ]);
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
        $this->view->setTemplate(false);
        $this->view->setLayout(false);
        $attachment = \kakalika\modules\issue_attachments\IssueAttachments::getJustFirstWithId($id);
        $file = "uploads/{$attachment->attachment_file}";
        
        header("Content-Type: {$attachment->type}");
        
        if(file_exists($file))
        {
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
            $this->view->setTemplate('issues_select_project.tpl.php');
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
