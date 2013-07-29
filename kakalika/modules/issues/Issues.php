<?php
namespace kakalika\modules\issues;

use ntentan\models\Model;

class Issues extends Model
{
    public function preSaveCallback()
    {
        $this->status = 'Open';
    }
}
