<?php
namespace kakalika\modules\projects;

use ntentan\Ntentan;
use kakalika\modules\issues\Issues;
use ntentan\Router;
use ntentan\Session;

class ProjectsController extends \kakalika\lib\KakalikaController
{
    private $userProjects;
    
    public function init()
    {
        parent::init();
        
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
                        'fields' => array('name', 'id')
                    ),
                    'components' => array(
                        'title' => 'Project Components',
                        'item' => 'component',
                        'items' => 'components',
                        'model' => 'components',
                        'fields' => array('name', 'id')
                    ),  
                    'members' => array(
                        'title' => 'Project Members',
                        'item' => 'member',
                        'items' => 'members',
                        'model' => 'user_projects',
                        'fields' => array('user.firstname', 'user.lastname', 'id'),
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
            throw new \ntentan\exceptions\RouteNotAvailableException();            
        }
        $this->setupCreateIssueButton();
    }
    
    public function run()
    {
        if(Router::getVar('MODE') == 'admin')
        {
            $projects = $this->model->fields('name', 'id')->fetch()->toArray();
        }
        else
        {
            $projects = $this->userProjects;     
            $statuses  = [];
            foreach($projects as $i => $project)
            {
                $myOpen = Issues::filter(
                    'project_id = ? and status in(?, ?, ?) and assignee = ?', 
                    $project->project->id, 'OPEN', 'REOPENED', 'RESOLVED', 
                    Session::get('user')['id']
                )->count();   

                $open = Issues::filter(
                    'project_id = ? and status in (?, ?, ?)',
                    $project->project->id, 'OPEN', 'REOPENED', 'RESOLVED'
                )->count();

                $resolved = Issues::filter(
                    'project_id = ? and status = ?',
                    $project->project->id, 'RESOLVED'
                )->count();
                
                $statuses[] = [
                    'mine' => $myOpen,
                    'open' => $open,
                    'resolved' => $resolved
                ];
            }
        }
        
        $this->set('projects', $projects->toArray());
    }
    
    public function email($id)
    {
        $project = $this->model->getJustFirstWithId($id);
        $this->set('id', $id);
        $this->set('project', $project->toArray());
        
        if(isset($_POST['incoming_server_host']))
        {
            $emailSettings = email_settings\EmailSettings::getFirstWithProjectId($id);
            
            if(isset($_POST['email_integration']) && $project->emal_integration == 0)
            {
                $project->email_integration = 1;
                $project->update();
            }
            else if($project->email_integration == 1)
            {
                $project->email_integration = 0;
                $project->update();
            }
            
            unset($_POST['email_integration']);
            
            if($emailSettings->count() == 0)
            {
                $emailSettings = email_settings\EmailSettings::getNew();
                $emailSettings->setData($_POST);
                $emailSettings->project_id = $id;
                $emailSettings->save();
            }
            else
            {
                $emailSettings->incoming_server_ssl = 0;
                $emailSettings->outgoing_server_authentication = 0;
                $emailSettings->setData($_POST);
                $emailSettings->update();
            }
            Ntentan::redirect(Ntentan::$requestedRoute);
        }
        else
        {
            $emailSettings = email_settings\EmailSettings::getFirstWithProjectId($id);
            $emailSettings->email_integration = $project->email_integration;
            $this->set('settings', $emailSettings->toArray());
        }
    }
    
    public function edit($code)
    {
        if(is_numeric($code))
        {
            $project = $this->model->getJustFirstWithId($code);            
        }
        else
        {
            $project = $this->model->getJustFirstWithCode($code);
        }
        
        $this->set('title', "Edit project {$project}");
        
        if(isset($_POST['name']))
        {
            $this->set('project', $_POST);
            $project->setData($_POST);
            if($project->update())
            {
                if($GLOBALS['ROUTE_MODE'] == 'admin')
                    Ntentan::redirect(Ntentan::getUrl("admin/projects"));
                else
                    Ntentan::redirect(Ntentan::getUrl("projects"));
            }
            else
            {
                $this->set('errors', $project->invalidFields);
            }
        }
        else 
        {
            $this->set('project', $project->toArray());
        }
    }
    
    public function delete($id)
    {
        $project = $this->model->getJustFirstWithId($id);
        $this->set('title', "Delete {$project} project");
        
        if($_GET['confirm'] == 'yes')
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
        if(isset($_POST['name']))
        {
            $newProject = Projects::getNew();
            $newProject->name = $_POST['name'];
            $newProject->code = $_POST['code'];
            $newProject->description = $_POST['description'];
            $newProjectId = $newProject->save();
            if($newProjectId)
            {
                $newUserProject = \kakalika\modules\user_projects\UserProjects::getNew();
                $newUserProject->user_id = $this->authComponent->userId();
                $newUserProject->project_id = $newProjectId;
                $newUserProject->creator = true;
                $newUserProject->admin = true;
                $newUserProject->save();
                
                if($GLOBALS['ROUTE_MODE'] == 'admin')
                {
                    Ntentan::redirect(Ntentan::getUrl('projects'));
                }
                else
                {
                    Ntentan::redirect(Ntentan::getUrl('admin/projects'));
                }
            }
            else
            {
                $this->set('project', $_POST);
                $this->set('errors', $newProject->invalidFields);
            }
        }
    }
}

