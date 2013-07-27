<?php
namespace kakalika\modules\issues;

class IssuesController extends \kakalika\lib\KakalikaController
{
    public function init()
    {
        if($GLOBALS["ROUTE_MODE"] == 'project')
        {
            $project = \kakalika\modules\projects\Projects::getJustFirstWithCode($GLOBALS['ROUTE_PROJECT_CODE']);
            if($project->count() == 0)
            {
                throw new \ntentan\exceptions\RouteNotAvailableException();
            }
        }
    }
    
    public function run()
    {
        
    }
}
