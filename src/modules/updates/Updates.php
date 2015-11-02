<?php
namespace kakalika\modules\updates;

class Updates extends \ntentan\Model
{
    public $belongsTo = array(
        'user',
        array('user', 'as' => 'assignee'),
        'milestone',
        'component'
    );
    
    public $hasMany = array('issue_attachments');    
    
    public $behaviours = array(
        'timestampable'
    );
    
    public $updateIssue = true;
    
    public function preSaveCallback() 
    {
        if($this->user_id == '') $this->user_id = $_SESSION['user']['id'];
    }
    
    public function postSaveCallback($id) 
    {
        if($this->updateIssue)
        {
            $issue = \kakalika\modules\issues\Issues::getJustFirstWithId($this->issue_id);
            $issue->updated = date('Y-m-d h:i:s');
            $issue->updater = $this->user_id;
            $issue->update();
        }
    }
}
