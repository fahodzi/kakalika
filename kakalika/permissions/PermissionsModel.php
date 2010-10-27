<?php
namespace kakalika\permissions;

use ntentan\models\Model;

class PermissionsModel extends Model
{
    public static $permissionGroups = array(
        "issues" => array(
            "can_create_issues",
            "can_edit_issues",
            "can_set_or_change_issue_status",
            "can_set_or_change_issue_priorities",
            "can_comment_on_issues"
        )
    );
}