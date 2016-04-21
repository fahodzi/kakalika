<?php
namespace kakalika\controllers;

use ntentan\Router;
use ntentan\utils\Input;
use ntentan\Session;
use kakalika\modules\watchers\Watchers;
use ntentan\Ntentan;
use kakalika\modules\projects\Projects;
use kakalika\modules\components\Components;
use kakalika\modules\issue_attachments\IssueAttachments;
use kakalika\modules\milestones\Milestones;
use kakalika\models\Issues;

class IssuesController extends \kakalika\lib\KakalikaController
{
    private $project;
    
    public function __construct()
    {
        parent::__construct();
        $this->set('sub_section', 'Issues');
        
        if(Router::getVar("mode") === 'project')
        {
            $this->project = Projects::fetchFirstWithCode(Router::getVar('project'));
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
    
    public function watch($issueNumber)
    {
        $this->getView()->setTemplate(false);
        $this->getView()->setLayout(false);
        $issue = Issues::fetchFirst(['project_id' => $this->project->id, 'number' => $issueNumber]);
        $issue->addWatcher(Session::get('user')['id'], true);
        Ntentan::redirect();
    }
    
    public function show($issueNumber)
    {
        $issue = Issues::filterByNumber($issueNumber)->filterByProjectId($this->project->id)->fetchFirst();
        
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
            $updatedIssue->updater = $this->authComponent->getUserId();
            $this->harvestAttachments($updatedIssue);
            $updatedIssue->save();
            
            \ntentan\Ntentan::redirect(Router::getRequestedRoute());
        }
        else
        {
            $watching = Watchers::filterByUserId(Session::get('user')['id'])
                ->filterByIssueId($issue->id)->count();
            $this->set('watching', $watching);
            $updates = \kakalika\modules\updates\Updates::sortAscByNumber()->fetchWithIssueId($issue->id);
            $this->set('updates', $updates);
            $this->set('issue', $issue);
        }
    }
    
    public function page($project, $filter, $sorter, $page)
    {
        $issues = Issues::filterByProjectId($this->project->id);

        switch ($filter)
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
        
        switch($sorter)
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
        $page = $page ? $page : 1;
        
        $numIssues = $issues->count();
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
        $issue = Issues::fetchFirst(['project_id' => $this->project->id, 'number' => $issueId]);
        $errors = [];
        $this->set('title', "Edit Issue #{$issue['number']} {$issue['title']}");
        if(Input::exists(Input::POST, 'title'))
        {
            $issue->mergeData(Input::post());
            $this->harvestAttachments($issue);
            if($issue->save()) {
                Ntentan::redirect("{$this->project->code}/issues/$issueId");
            } else {
                $errors = $issue->getInvalidFields();
            }
        }
        else
        {
            $this->set('form_data', $issue->toArray());
            $this->setupOptions();
        }
        $this->set('form_errors', $errors);
    }
    
    public function attachment($id)
    {
        $this->view->setTemplate(false);
        $this->view->setLayout(false);
        $attachment = IssueAttachments::getJustFirstWithId($id);
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
        $errors = [];
        if(Input::exists(Input::POST, 'title'))
        {
            $newIssue = Issues::createNew();
            $newIssue->setData(Input::post());
            $newIssue->project_id = $this->project->id;
            $this->harvestAttachments($newIssue);            
            
            if($newIssue->save()) {
                Ntentan::redirect("{$this->project->code}/issues");
            } else {
                $errors = $newIssue->getInvalidFields();
            }
        }
        
        $this->set(['data' => Input::post(), 'errors' => $errors]);        
        
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
        $users = $this->project->users;
        
        $assignees = array();
        
        foreach($users as $user)
        {
            $assignees[$user->id] = (string)$user;
        }
        
        $this->set('assignees', $assignees);   
        
        $components = Components::fetchWithProjectId($this->project->id);
        $componentsOptions = array();
        foreach($components as $component)
        {
            $componentsOptions[$component->id] = $component->name;
        }
        $this->set('components', $componentsOptions);
        
        $milestones = Milestones::fetchWithProjectId($this->project->id);
        $milestonesOptions = array();
        foreach($milestones as $milestone)
        {
            $milestonesOptions[$milestone->id] = $milestone->name;
        }
         
       $this->set('milestones', $milestonesOptions);
    }
}
