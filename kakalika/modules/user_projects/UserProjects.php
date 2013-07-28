<?php
namespace kakalika\modules\user_projects;

use ntentan\models\Model;

class UserProjects extends Model
{
    public $belongsTo = array(
        'project',
        'user'
    );
}
