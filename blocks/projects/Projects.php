<?php
namespace kakalika\blocks\projects;

require_once "kakalika/projects/Projects.php";

use ntentan\views\blocks\Block;
use kakalika\projects\ProjectsModel;

class Projects extends Block
{
    public function __construct()
    {
        $projects = \kakalika\projects\Projects::getAll(
            array(
                "fields" => array(
                    "id",
                    "name",
                    "machine_name"
                ),
                "conditions" => array(
                    "project_users.user_id" => \ntentan\controllers\components\auth\Auth::userId()
                ),
                "through" => array("project_users")
            )
        );
        $projects = $projects->getData();
        $this->set("projects", $projects);
    }
}
