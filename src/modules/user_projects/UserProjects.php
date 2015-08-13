<?php
namespace kakalika\modules\user_projects;

use ntentan\Model;

class UserProjects extends Model
{
    public $belongsTo = [
        'projects',
        'users'
    ];

    public function validate()
    {
        $validation= parent::validate();

        $user = $this->getJustFirst(
            array(
                'conditions' => array(
                    'user_id' => $this->user_id,
                    'project_id' => $this->project_id
                )
            )
        );

        if($user->count() == 1)
        {
            $this->invalidFields['user_id'][] = 'This user is already part of this project';
            return false;
        }

        return $validation;
    }

    public function __toString()
    {
        return "{$this->user->firstname} {$this->user->lastname}, {$this->project->name}";
    }

    public function getVars()
    {
        $users = \kakalika\modules\users\Users::getAll();
        $newUsers = array();
        foreach($users as $i => $user)
        {
            $newUsers[$user['id']] = "{$user['firstname']} {$user['lastname']} ({$user['username']})";
        }
    }
}
