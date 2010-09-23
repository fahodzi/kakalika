<?php
namespace kakalika\projects;

use ntentan\models\Model;

class ProjectsModel extends Model
{
    public function __toString()
    {
        return $this["name"];
    }
}