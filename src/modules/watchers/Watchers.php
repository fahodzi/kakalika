<?php
namespace kakalika\modules\watchers;
use ntentan\models\Model;

class Watchers extends Model
{
    public $belongsTo = array(
        'user'
    );
}
