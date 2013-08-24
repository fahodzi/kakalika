<?php
namespace kakalika\modules\updates;

class Updates extends \ntentan\models\Model
{
    public $belongsTo = array(
        'user'
    );
    
    public $behaviours = array(
        'timestampable'
    );
    
    public function postSaveCallback($id) 
    {
        $issue = \kakalika\modules\issues\Issues::getJustFirstWithId($this->issue_id);
        $issue->updated = date('Y-m-d h:i:s');
        $issue->updater = $_SESSION['user']['id'];
        $issue->update();
    }
}
