<?php
namespace kakalika\modules\issues;

use ntentan\models\Model;

class Issues extends Model
{
    public $belongsTo = array(
        array('user', 'as' => 'opener'),
        array('user', 'as' => 'assignee'),
        array('user', 'as' => 'updater'),
        'project',
        'milestone',
        'component'
    );
    
    public $hasMany = array('updates', 'issue_attachments');
    
    public $behaviours = array(
        'timestampable'
    );
    
    private $originalIssue;
    private $updateData = array();
    private $attachments = array();
    
    public function validate()
    {
        $valid = parent::validate();
        
        // Validate attachments
        if(count($_FILES['attachment']) > 0)
        {
            foreach($_FILES['attachment']['error'] as $index => $error)
            {
                if($error == UPLOAD_ERR_OK)
                {
                    $this->attachments[] = array(
                        'tmp_file' => $_FILES['attachment']['tmp_name'][$index],
                        'name' => $_FILES['attachment']['name'][$index],
                        'size' => $_FILES['attachment']['size'][$index],
                        'type' => $_FILES['attachment']['type'][$index]
                    );
                }
                else
                {
                    $valid = false;
                }
            }
        }

        return $valid;
    }
    
    public function preUpdateCallback() 
    {
        $this->updater = $_SESSION['user']['id'];
        $this->updated = date('Y-m-d H:i:s');
        $this->originalIssue = $this->getJustFirstWithId($this->id)->toArray();
        
        if($this->data['comment'] != '') 
        {
            $this->updateData['comment'] = $this->data['comment'];
        }
        
        if($this->originalIssue['assignee'] != $this->assignee) 
        {
            $this->updateData['assignee'] = $this->assignee;
            $this->assigned = date('Y-m-d H:i:s');
        }
        
        if($this->originalIssue['kind'] != $this->kind) $this->updateData['kind'] = $this->kind;
        if($this->originalIssue['priority'] != $this->priority) $this->updateData['priority'] = $this->priority;
        if($this->originalIssue['status'] != $this->status) $this->updateData['status'] = $this->status;
        if($this->originalIssue['milestone_id'] != $this->milestone_id) $this->updateData['milestone_id'] = $this->milestone_id;
        if($this->originalIssue['component_id'] != $this->component_id) $this->updateData['component_id'] = $this->component_id;
        
        unset($this->data['comment']);    
        
        if(count($this->updateData) > 0)
        {
            $this->updateData['number'] = ++$this->number_of_updates;
        }
    }
    
    public function postUpdateCallback() 
    {        
        if(count($this->updateData) > 0)
        {
            $this->updateData['issue_id'] = $this->id;        
            $update = \kakalika\modules\updates\Updates::getNew();
            $update->setData($this->updateData);
            $update->updateIssue = false;
            $updateId = $update->save();
                        
            foreach($this->attachments as $attachment)
            {
                $destination = uniqid() . "_{$attachment['name']}";
                move_uploaded_file($attachment['tmp_file'], "uploads/$destination");
                $issueAttachment = \kakalika\modules\issue_attachments\IssueAttachments::getNew();
                $issueAttachment->issue_id = $this->id;
                $issueAttachment->attachment_file = $destination;
                $issueAttachment->name = $attachment['name'];
                $issueAttachment->type = $attachment['type'];
                $issueAttachment->user_id = $_SESSION['user']['id'];
                $issueAttachment->size = $attachment['size'];
                $issueAttachment->update_id = $updateId;
                $issueAttachment->save();
            }
        }
    }
    
    public function preSaveCallback()
    {
        $this->status = 'OPEN';
        $this->opener = $_SESSION['user']['id'];
        $project = \kakalika\modules\projects\Projects::getJustFirstWithId(
            $this->project_id
        );
        if($this->assignee != '')
        {
            $this->assigned = date('Y-m-d H:i:s');
        }
        $this->number = ++$project->number_of_issues;
        $project->update();
    }
    
    public function postSaveCallback($id) 
    {
        foreach($this->attachments as $attachment)
        {
            $destination = uniqid() . "_{$attachment['name']}";
            move_uploaded_file($attachment['tmp_file'], "uploads/$destination");
            $issueAttachment = \kakalika\modules\issue_attachments\IssueAttachments::getNew();
            $issueAttachment->issue_id = $id;
            $issueAttachment->attachment_file = $destination;
            $issueAttachment->name = $attachment['name'];
            $issueAttachment->type = $attachment['type'];
            $issueAttachment->user_id = $_SESSION['user']['id'];
            $issueAttachment->size = $attachment['size'];
            $issueAttachment->save();
        }
    }
}
