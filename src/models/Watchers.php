<?php
namespace kakalika\modules\watchers;
use ntentan\Model;

class Watchers extends Model
{
    public $belongsTo = array(
        'user'
    );
}
