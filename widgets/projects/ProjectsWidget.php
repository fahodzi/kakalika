<?php
namespace kakalika\widgets\projects;

require_once "kakalika/projects/Projects.php";

use ntentan\views\widgets\Widget;
use kakalika\projects\ProjectsModel;

class ProjectsWidget extends Widget
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
