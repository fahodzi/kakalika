<?php
namespace kakalika\models;

use ntentan\Model;

class Users extends Model
{
    public $manyHaveMany = ['projects'];

    public function __toString()
    {
        return "$this->firstname $this->lastname";
    }
}
