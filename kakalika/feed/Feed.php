<?php
namespace kakalika\feed;

use ntentan\models\Model;

class Feed extends Model
{
    public $belongsTo = array("project", "user");
}