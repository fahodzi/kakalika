<?php
namespace kakalika\lib;

use ntentan\views\template_engines\TemplateEngine;

use ntentan\controllers\Controller;

class KakalikaController extends Controller
{
    public function init()
    {
        parent::init();
        TemplateEngine::appendPath('views/layouts');
        $this->addComponent('auth', array(
            'login_route' => 'login'
        ));
        if(!$this->authComponent->loggedIn())
        {
            $this->view->layout = 'login_layout.tpl.php';
        }
    }    
}
