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
                    'label' => 'Create new project',
                    'url' => Ntentan::getUrl('projects/create')
                )
            )
        );
    }
    
    public function run()
    {
        
    }
    
    public function create()
    {
        
    }
}
