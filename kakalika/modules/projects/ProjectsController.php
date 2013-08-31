<?php
namespace kakalika\modules\projects;

use ntentan\Ntentan;

class ProjectsController extends \kakalika\lib\KakalikaController
{
    public function init()
    {
        parent::init();
        
        $this->set('sub_section', 'Projects');
        
        if($GLOBALS['ROUTE_MODE'] == 'admin')
        {
            $this->set('admin', true);
            $this->set('sub_section_menu', 
                array(
                    array(
                        'label' => 'Create a new project',
                        'url' => Ntentan::getUrl('admin/projects/create')
                    )
                )
            );            
        }
        else
        {
            if($_SESSION['user']['is_admin'])
            {
                $this->set('sub_section_menu', 
                    array(
                        array(
                            'label' => 'Create a new project',
                            'url' => Ntentan::getUrl('projects/create')
                        )
                    )
                );
            }
        }
    }
    
    public function run()
    {
        if($GLOBALS['ROUTE_MODE'] == 'admin')
        {
            $projects = $this->model->getAll(
                array('fields' => array('name', 'id'))
            );            
        }
        else
        {
            $projects = \kakalika\modules\user_projects\UserProjects::getAllWithUserId(
                $this->authComponent->userId()
            );
        }
        
        $this->set('projects', $projects->toArray());
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
    
    public function members($id, $command = '')
    {
        $this->set('sub_section', 'Project Members');
        $this->set('sub_section_menu', 
            array(
                array(
                    'label' => 'Assign a new Member',
                    'url' => Ntentan::getUrl("admin/projects/members/$id/assign")
                )
            )
        );         
        
        switch($command)
        {
        case 'assign':
            if(isset($_POST['user_id']) && $_POST['user_id'] != '')
            {
                $userProject = \kakalika\modules\user_projects\UserProjects::getNew();
                $userProject->project_id = $id;
                $userProject->user_id = $_POST['user_id'];
                if($userProject->save())
                {
                    Ntentan::redirect(Ntentan::getUrl("admin/projects/members/$id"));
                }
                else
                {
                    $this->set('errors', $userProject->invalidField);
                }
            }
            
            $this->view->template = 'projects_members_assign.tpl.php';
            $users = \kakalika\modules\users\Users::getAll();
            $newUsers = array();
            foreach($users as $i => $user)
            {
                $newUsers[$user['id']] = "{$user['firstname']} {$user['lastname']} ({$user['username']})";
            }
            
            $this->set('users', $newUsers);
            break;
        
        default:

            $projectMembers = \kakalika\modules\user_projects\UserProjects::getWithProjectId(
                $id,
                array(
                    'fields' => array(
                        'id',
                        'user.firstname',
                        'user.lastname',
                        'user.username'
                    )
                )
            );
            $redoneProjectMembers = array();

            foreach($projectMembers as $i => $member)
            {
                $redoneProjectMembers[] = array(
                    'firstname' => $member['user']['firstname'],
                    'lastname' => $member['user']['lastname'],
                    'username' => $member['user']['username'],
                    'id' => $member['id']
                );
            }

            $this->set('members', $redoneProjectMembers);            
        }
    }    
    
    public function create()
    {
        $this->set('split', true);
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
