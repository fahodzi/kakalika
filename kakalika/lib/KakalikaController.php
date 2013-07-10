<?php
namespace kakalika\lib;

use ntentan\views\template_engines\TemplateEngine;

use ntentan\controllers\Controller;

class KakalikaController extends Controller
{
    public function init()
    {
        parent::init();
        $this->addComponent('auth');
    }    
}
