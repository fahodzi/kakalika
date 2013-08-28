<?php
namespace kakalika\modules\projects;

use ntentan\Ntentan;

class ProjectsController extends \kakalika\lib\KakalikaController
{
    public function init()
    {
        parent::init();
        
        $this->set('sub_section', 'Projects');
        $this->set('sub_section_menu', 
            array(
                array(
                    'label' => 'Create a new project',
                    'url' => Ntentan::getUrl('projects/create')
                )
            )
        );
    }
    
    public function run()
    {
        $projects = \kakalika\modules\user_projects\UserProjects::getAllWithUserId(
            $this->authComponent->userId()
        );
        $this->set('projects', $projects->toArray());
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
            
            if($newProjectId === false)
            {
                var_dump($newProject->invalidFields);
            }
            else
            {
                $newUserProject = \kakalika\modules\user_projects\UserProjects::getNew();
                $newUserProject->user_id = $this->authComponent->userId();
                $newUserProject->project_id = $newProjectId;
                $newUserProject->creator = true;
                $newUserProject->admin = true;
                $newUserProject->save();
                
                Ntentan::redirect(Ntentan::getUrl('projects'));
            }
        }
    }
}
