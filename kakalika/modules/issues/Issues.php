<?php
namespace kakalika\modules\issues;

use ntentan\models\Model;

class Issues extends Model
{
    public $belongsTo = array(
        array('user', 'as' => 'opener')
    );
    
    public $behaviours = array(
        'timestampable'
    );
    
    public function preSaveCallback()
    {
        $this->status = 'Open';
        $this->opener = $_SESSION['user']['id'];
        $project = \kakalika\modules\projects\Projects::getJustFirstWithId(
            $this->project_id
        );
        $this->number = ++$project->number_of_issues;
        $project->update();
    }
}
