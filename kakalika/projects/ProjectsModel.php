<?php
namespace kakalika\projects;

use ntentan\models\Model;

class ProjectsModel extends Model
{
    public $hasMany = array(
        "roles"
    );
    public function __toString()
    {
        return $this["name"];
    }
    
    public function preSaveCallback()
    {
        $this->data["roles"] = array(
            array(
                "name" => "Project Administrator"
            )
        );
    }
}