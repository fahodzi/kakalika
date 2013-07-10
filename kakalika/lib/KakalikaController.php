<?php
namespace kakalika\lib;

use ntentan\controllers\Controller;

class KakalikaController extends Controller
{
    public function init()
    {
        $this->addComponent('auth');
    }
}
