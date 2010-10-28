<?php
namespace kakalika\blocks\projects;

require_once "kakalika/projects/ProjectsModel.php";

use ntentan\views\blocks\Block;
use kakalika\projects\ProjectsModel;

class Projects extends Block
{
    public function __construct()
    {
        $projects = ProjectsModel::getAll(
            array(
                "fields" => array(
                    "projects.id",
                    "projects.name",
                    "projects.machine_name"
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