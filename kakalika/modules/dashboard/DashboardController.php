<?php
namespace kakalika\modules\dashboard;

use kakalika\lib\KakalikaController;

/**
 * 
 * @author ekow
 */
class DashboardController extends KakalikaController
{
    public function init()
    {
        $this->set('sub_section', 'Dashboard');
    }
    
    public function run()
    {
        
    }
}

