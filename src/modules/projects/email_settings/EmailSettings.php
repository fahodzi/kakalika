<?php
namespace kakalika\modules\projects\email_settings;

use ntentan\Model;

class EmailSettings extends Model
{
    public $belongsTo = array('project');
}