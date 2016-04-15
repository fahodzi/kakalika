<?php
namespace kakalika\modules\projects;

use ntentan\Ntentan;
use kakalika\modules\issues\Issues;
use ntentan\Router;
use ntentan\Session;
use ntentan\utils\Input;

class ProjectsController extends \kakalika\lib\KakalikaController
{
    private $userProjects;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->set('sub_section', 'Projects');
        $this->set('title', 'Projects');
        
        $this->userProjects = $this->getUserProjects();  
        
        if(Router::getVar('MODE') == 'admin' && Session::get('user')['is_admin'] == true)
        {
            $this->set('admin', true);
            $this->set('sub_section_path', 'admin/projects');    
            $this->addComponent('submodule', 
                array(
                    'milestones' => array(
                        'title' => 'Project Milestones',
                        'item' => 'milestone',
                        'items' => 'milestones',
                        'model' => 'milestones',
                        'fields' => array('name', 'id'),
                        'filter' => null,
                        'disable_edit' => null,
                        'get_form_vars' => null
                    ),
                    'components' => array(
                        'title' => 'Project Components',
                        'item' => 'component',
                        'items' => 'components',
                        'model' => 'components',
                        'fields' => array('name', 'id'),
                        'filter' => null,
                        'disable_edit' => null,
                        'get_form_vars' => null
                    ),  
                    'members' => array(
                        'title' => 'Project Members',
                        'item' => 'member',
                        'items' => 'members',
                        'model' => 'projects_users',
                        'fields' => array('id', 'user_id'),
                        'disable_edit' => true,
                        
                        'get_form_vars' => function() 
                        {
                            $users = \kakalika\modules\users\Users::fetch();
                            $newUsers = array();
                            foreach($users as $i => $user)
                            {
                                $newUsers[$user['id']] = "{$user['firstname']} {$user['lastname']} ({$user['username']})";
                            } 
                            return array(
                                'users' => $newUsers
                            );
                        },
                                
                        'filter' => function($items) 
                        {
                            $returnItems = array();
                            foreach($items as $item)
                            {
                                $returnItems[] = array(
                                    'name' => "{$item['user']['firstname']} {$item['user']['lastname']}",
                                    'id' => $item['id']
                                );
                            }
                            return $returnItems;
                        }
                    )
                )
            );
        }
        else if(Router::getRoute() == 'projects')
        {
            $this->set('sub_section_path', 'projects');
        }

        $this->setupCreateIssueButton();
    }
    
    public function index()
    {
        if(Router::getVar('mode') == 'admin')
        {
            $projects = Projects::fields('name', 'id')->fetch()->toArray();
            $this->set('admin', true);
        }
        else
        {
            $projects = $this->userProjects->toArray();     
            foreach($projects as $i => $project)
            {
                $myOpen = Issues::filter(
                    'project_id = ? and status in(?, ?, ?) and assignee = ?', 
                    $project['id'], 'OPEN', 'REOPENED', 'RESOLVED', 
                    Session::get('user')['id']
                )->count(); 
                $projects[$i]['my_open']  = $myOpen;                

                $open = Issues::filter(
                    'project_id = ? and status in (?, ?, ?)',
                    $project['id'], 'OPEN', 'REOPENED', 'RESOLVED'
                )->count();
                $projects[$i]['open'] = $open;                

                $resolved = Issues::filter(
                    'project_id = ? and status = ?',
                    $project['id'], 'RESOLVED'
                )->count();
                $projects[$i]['resolved'] = $resolved;                
            }
        }
        
        $this->set('projects', $projects);
    }
    
    public function email($id)
    {
        $project = Projects::fetchFirstWithId($id);
        $this->set('id', $id);
        $this->set('project', $project->toArray());
        
        if(Input::exists(Input::POST, 'incoming_server_host'))
        {
            $emailSettings = email_settings\EmailSettings::fetchFirstWithProjectId($id);
            
            if(Input::exists(Input::POST, 'email_integration') && $project->email_integration == 0)
            {
                $project->email_integration = 1;
                $project->save();
            }
            else if($project->email_integration == 1)
            {
                $project->email_integration = 0;
                $project->save();
            }
            
            $data = Input::post();
            unset($data['email_integration']);
            
            if($emailSettings->count() == 0)
            {
                $emailSettings = email_settings\EmailSettings::getNew();
                $emailSettings->setData($data);
                $emailSettings->project_id = $id;
                $emailSettings->save();
            }
            else
            {
                $emailSettings->incoming_server_ssl = 0;
                $emailSettings->outgoing_server_authentication = 0;
                $emailSettings->mergeData($data);
                $emailSettings->save();
            }
            Ntentan::redirect(Router::getRequestedRoute());
        }
        else
        {
            $emailSettings = email_settings\EmailSettings::fetchFirstWithProjectId($id);
            $emailSettings->email_integration = $project->email_integration;
            $this->set('settings', $emailSettings->toArray());
        }
    }
    
    public function edit($id)
    {
        $errors = [];
        if(is_numeric($id))
        {
            $project = Projects::fetchFirstWithId($id);            
        }
        else
        {
            $project = Projects::fetchFirstWithCode($id);
        }
        
        $this->set('title', "Edit project {$project}");
        $this->set('project', $project);
    }
    
    /**
     * @ntentan.action edit
     * @ntentan.verb POST
     * @param \kakalika\modules\projects\Projects $project
     */
    public function update(Projects $project)
    {
        if($project->save())
        {
            $this->redirect('projects');
        }
        else
        {
            $this->set('errors', $project->getInvalidFields());
            $this->set('project', Input::post());
        }
    }
    
    public function delete($id, $confirm)
    {
        $project = Projects::fetchFirstWithId($id);
        $this->set('title', "Delete {$project} project");
        
        if($confirm == 'yes')
        {
            $project->delete();
            $this->redirect('projects');
        }
        
        $this->set(
            array(
                'item_type' => 'project',
                'item_name' => $project,
                'id' => $id,
                'show_side' =>true
            )
        );        
    }
    
    public function create()
    {
        $project = Projects::createNew();
        $project->userId = Session::get('user')['id'];
        $this->set('title', 'Create a new project');
        $this->set('project', $project);
    }
    
    /**
     * @ntentan.action create
     * @ntentan.verb POST
     * 
     * @param \kakalika\modules\projects\Projects $project
     * @param int $userId
     * @return void
     */
    public function store(Projects $project = null, $userId)
    {
        $project->userId = $userId;
        $this->set('title', 'Create a new project');
        if($project->save()) {
            return $this->redirect('projects');
        }
        $this->set('project', $project);
        $this->set('errors', $project->getInvalidFields());
    }
    
    private function redirect($url)
    {
        if(Router::getVar('mode') == 'admin') {
            Ntentan::redirect("admin/$url");
        } else {
            Ntentan::redirect($url);
        }
    }
}

