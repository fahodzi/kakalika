<?php
namespace kakalika\modules\issues;

class IssuesController extends \kakalika\lib\KakalikaController
{
    private $projectId;
    
    public function init()
    {
        parent::init();
        if($GLOBALS["ROUTE_MODE"] == 'project')
        {
            $project = \kakalika\modules\projects\Projects::getJustFirstWithCode($GLOBALS['ROUTE_PROJECT_CODE']);
            
            $this->set('sub_section', $project->name);
            $this->set('sub_section_menu', 
                array(
                    array(
                        'label' => 'New Issue',
                        'url' => \ntentan\Ntentan::getUrl("{$project->code}/issues/create")
                    )
                )
            );
                        
            $this->projectId = $project->id;
            
            if($project->count() == 0)
            {
                throw new \ntentan\exceptions\RouteNotAvailableException();
            }
        }   
        else 
        {
            $this->set('sub_section', "All Issues");
        }
    }
    
    public function run()
    {
        
    }
    
    public function create()
    {
        $users = \kakalika\modules\user_projects\UserProjects::getAllWithProjectId(
            $this->projectId,
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
