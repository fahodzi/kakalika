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
                        'label' => 'New Issue',
                        'url' => \ntentan\Ntentan::getUrl("{$this->project->code}/issues/create")
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
        if(isset($_POST['comment']))
        {
            $update = Updates::getNew();
            $update->comment = $_POST['comment'];
            $update->user_id = $_SESSION['user']['id'];
            $update->issue_id = $issueId;
            $update->save();
            \ntentan\Ntentan::redirect(\ntentan\Ntentan::$requestedRoute);
        }
        else
        {
            $issue = $this->model->getFirstWithId($issueId);        
            $this->set('issue', $issue->toArray());
        }
    }
    
    public function run()
    {
        $issues = Issues::getAll(
            array(
                'sort' => 'id DESC'
            )
        );
        $this->set('issues', $issues);
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
        $this->set('split', true);
    }
}
