<?php
namespace kakalika\modules\issues;

use ntentan\models\Model;

class Issues extends Model
{
    public function preSaveCallback()
    {
        $this->status = 'Open';
        $project = \kakalika\modules\projects\Projects::getJustFirstWithId(
            $this->project_id
        );
        $this->number = ++$project->number_of_issues;
        $project->update();
    }
}
