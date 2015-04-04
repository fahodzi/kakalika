<?php
namespace kakalika\lib;

use ntentan\views\template_engines\TemplateEngine;
use ntentan\controllers\Controller;
use ntentan\Ntentan;

class KakalikaController extends Controller
{
    public function init()
    {
        parent::init();
        
        if(is_readable("install"))
        {
            $this->set("install_active", true);
        }
        
        TemplateEngine::appendPath('views/layouts');
        TemplateEngine::appendPath('views/partials');
        TemplateEngine::appendPath('views/forms');
        
        $this->addComponent('auth', array(
            'login_route' => 'login',
            'logout_route' => 'logout'
        ));
        
        if(!$this->authComponent->loggedIn())
        {
            $this->view->layout = 'login_layout.tpl.php';
        }
    }
    
    protected function getUserProjects()
    {
        //@todo Find a way to store this in some kind of cache
        return \kakalika\modules\user_projects\UserProjects::getAllWithUserId(
            $this->authComponent->userId()
        ); 
    }
    
    protected function setupCreateIssueButton()
    {
        $this->set('sub_section_menu', 
            array(
                array(
                    'label' => 'Create a new issue',
                    'url' => $GLOBALS['ROUTE_MODE'] == 'project' ? Ntentan::getUrl("{$GLOBALS['ROUTE_PROJECT_CODE']}/issues/create") : Ntentan::getUrl('issues/create'),
                    'id' => 'menu-item-issues-create'
                )
            )
        );
        $projectsMenu = array();

        foreach($this->getUserProjects() as $userProject)
        {
            $projectsMenu[] = array(
                'label' => $userProject->project->name,
                'url' => Ntentan::getUrl($userProject->project->code . "/issues/create")
            );
        }

        $this->set('sub_section_menu_sub_menu', $projectsMenu);
    }
}
