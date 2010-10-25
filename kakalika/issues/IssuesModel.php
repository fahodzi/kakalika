<?php
namespace kakalika\issues;

use ntentan\models\Model;

class IssuesModel extends Model
{
    public $belongsTo = array(
        array("user", "as" => "creator"),
        array("user", "as" => "assignee")
    );
}