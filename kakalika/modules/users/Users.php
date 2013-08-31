<?php
namespace kakalika\modules\users;

use ntentan\models\Model;

class Users extends Model
{
    public function __toString()
    {
        return "$this->firstname $this->lastname";
    }
}
