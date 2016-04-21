<?php
namespace kakalika\lib;

use ntentan\honam\TemplateEngine;
use ntentan\Controller;
use ntentan\Ntentan;
use ntentan\Router;
use ntentan\View;

class KakalikaController extends Controller
{
    public function __construct()
    {        
        if(is_readable("install"))
        {
            View::set("install_active", true);
        }
        
        TemplateEngine::appendPath('views/layouts');
        TemplateEngine::appendPath('views/partials');
        TemplateEngine::appendPath('views/forms');
        
        $this->addComponent('auth');
        
        $this->addComponent('auth', array(
            'login_route' => 'login',
            'logout_route' => 'logout'
        ));
        
        if(!$this->authComponent->loggedIn())
        {
            $this->getView()->setLayout('login_layout.tpl.php');
        }
    }
    
    protected function getUserProjects()
    {
        //@todo Find a way to store this in some kind of cache
        $user = \kakalika\models\Users::fetchFirstWithId($this->authComponent->getUserId());
        return $user->projects;
    }
    
    protected function setupCreateIssueButton()
    {
        View::set('sub_section_menu', 
            array(
                array(
                    'label' => 'Create a new issue',
                    'url' => Router::getVar('MODE') == 'project' ? Ntentan::getUrl(Router::getVar('PROJECT_CODE') . "/issues/create") : Ntentan::getUrl('issues/create'),
                    'id' => 'menu-item-issues-create'
                )
            )
        );
        $projectsMenu = array();

        foreach($this->getUserProjects() as $userProject)
        {
            $projectsMenu[] = array(
                'label' => $userProject->name,
                'url' => Ntentan::getUrl($userProject->code . "/issues/create")
            );
        }

        View::set('sub_section_menu_sub_menu', $projectsMenu);
    }
}
