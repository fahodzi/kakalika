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
        else if(Router::getRoute() == 'projects/create' && Session::get('user')['is_admin'])
        {
            // Just allow the admins to go through
        }
        else
        {
            // Throw an exception for others
            //throw new \ntentan\exceptions\RouteNotAvailableException();            
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
    
    public function edit($code)
    {
        $errors = [];
        if(is_numeric($code))
        {
            $project = Projects::fetchFirstWithId($code);            
        }
        else
        {
            $project = Projects::fetchFirstWithCode($code);
        }
        
        $this->set('title', "Edit project {$project}");
        
        if(Input::exists(Input::POST, 'name'))
        {
            $this->set('project', Input::post());
            
            $id = $project->id;
            $project->setData(Input::post());
            $project->id = $id;
            
            if($project->save())
            {
                if(Router::getVar('MODE') == 'admin')
                    Ntentan::redirect(Ntentan::getUrl("admin/projects"));
                else
                    Ntentan::redirect(Ntentan::getUrl("projects"));
            }
            else
            {
                $errors = $project->getInvalidFields();
            }
        }
        
        $this->set('project', $project->toArray());
        $this->set('errors', $errors);
    }
    
    public function delete($id)
    {
        $project = Projects::fetchFirstWithId($id);
        $this->set('title', "Delete {$project} project");
        
        if(Input::get('confirm') == 'yes')
        {
            $project->delete();
            Ntentan::redirect(Ntentan::getUrl("admin/projects"));
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
        $this->set('title', 'Create a new project');
        $project = [];
        $errors = [];
        if(Input::exists(Input::POST, 'name'))
        {
            $newProject = Projects::createNew();
            $newProject->name = Input::post('name');
            $newProject->code = Input::post('code');
            $newProject->description = Input::post('description');
            $newProject->user_id = $this->authComponent->getUserId();
            
            if($newProject->save())
            {
                if($GLOBALS['ROUTE_MODE'] == 'admin')
                {
                    Ntentan::redirect(Ntentan::getUrl('projects'));
                }
                else
                {
                    Ntentan::redirect(Ntentan::getUrl('admin/projects'));
                }
            }
            
            $project = Input::post();
            $errors = $newProject->getInvalidFields();
        }
        $this->set('project', $project);
        $this->set('errors', $errors);        
    }
}

