<?php
namespace kakalika\modules\error;

class ErrorController extends \kakalika\lib\KakalikaController
{
    public function run()
    {
        $this->set('title', 'Error');
    }
}