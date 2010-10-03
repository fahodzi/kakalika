<?php
namespace kakalika\feed;

use ntentan\models\Model;

class FeedModel extends Model
{
    public $belongsTo = array("project","user");
}