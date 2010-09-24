<?php
namespace kakalika\roles;

use ntentan\models\Model;

class RolesModel extends Model
{
    public $belongsTo = "project";
}
