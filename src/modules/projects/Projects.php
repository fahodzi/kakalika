<?php

namespace kakalika\modules\projects;

use ntentan\Model;
use kakalika\modules\user_projects\UserProjects;

class Projects extends Model
{
    private $storedUserId;
    public $manyHaveMany = ['users'];
    
    public function __toString()
    {
        return $this->name;
    }
    
    public function preSaveCallback()
    {
        $this->storedUserId = $this['user_id'];
        $this->usetField('user_id');
    }
    
    public function postSaveCallback($id)
    {
        $newUserProject = UserProjects::createNew();
        $newUserProject->user_id = $this->storedUserId;
        $newUserProject->project_id = $id;
        $newUserProject->creator = true;
        $newUserProject->admin = true;
        $newUserProject->save();
    }

}
