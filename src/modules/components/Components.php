<?php
namespace kakalika\modules\components;

class Components extends \ntentan\models\Model
{
    public $belongsTo = array(
        'project'
    );
        
    public function __toString()
    {
        return "{$this->project->name}, {$this->name}";
    }    
}

