<?php
namespace kakalika\modules\projects;

use ntentan\models\Model;

class Projects extends Model
{
    public function __toString() {
        return $this->name;
    }
}
