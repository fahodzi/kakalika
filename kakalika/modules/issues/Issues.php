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
        if($this->updater == '') $this->updater = $_SESSION['user']['id'];
        if($this->updated == '') $this->updated = date('Y-m-d H:i:s');
        
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
            $this->updateData['user_id'] = $this->updater;
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
            
            $this->addWatcher($this->updater);
            $this->addWatcher($this->assignee);
                        
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
        
        $this->notify($this->updateData['comment']);        
    }
    
    public function preSaveCallback()
    {
        $this->status = 'OPEN';
        if(isset($_SESSION['user']['id'])) $this->opener = $_SESSION['user']['id'];
        $project = \kakalika\modules\projects\Projects::getJustFirstWithId(
            $this->project_id
        );
        if($this->assignee != '')
        {
            $this->assigned = date('Y-m-d H:i:s');
        }
        $this->number = ++$project->number_of_issues;
        if($this->updated == '') $this->updated = date('Y-m-d H:i:s');
        $project->update();
    }
    
    public function addWatcher($userId)
    {
        $watcher = \kakalika\modules\watchers\Watchers::getJustFirst(
            array(
                'conditions' => array(
                    'issue_id' => $this->id,
                    'user_id' => $userId
                )
            )
        );

        if($watcher->count() == 0)
        {
            $watcher->user_id = $userId;
            $watcher->issue_id = $this->id;
            $watcher->save();
        }        
    }
    
    public function postSaveCallback($id) 
    {
        $this->addWatcher($this->opener);
        
        if($this->assignee != '' && $this->assignee != $this->opener)
        {
            $this->addWatcher($this->assignee);
        }
        
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
        
        $this->notify($this->description);
    }
    
    public function notify($message)    
    {
        $watchers = \kakalika\modules\watchers\Watchers::getAll(
            array(
                'conditions' => array(
                    'issue_id' => $this->id,
                    'user_id<>' => $_SESSION['user']['id']
                )
            )
        );
        
        foreach($watchers as $watcher)
        {
            $watcher = $watcher->toArray();
            
            $emailSender = new \kakalika\lib\EmailSender();
            $emailSender->setDestination($watcher['user']['email'], "{$watcher['user']['firstname']} {$watcher['user']['lastname']}");
            $emailSender->setMessage($message);
            $emailSender->setSource("{$_SESSION['user']['firstname']} {$_SESSION['user']['lastname']} {$_SESSION['othernames']}");            
            $outgoingMail = \kakalika\modules\outgoing_mails\OutgoingMails::getNew();
            
            if($this->project_id == '' || $this->number == '' || $this->tite == '')
            {
                $issue = Issues::getJustFirstWithId($this->id, array('fields'=>array('project_id', 'number', 'title')));
                $outgoingMail->project_id = $issue->project_id;
                $emailSender->setIssueNumber($issue->number);
                $emailSender->setSubject($issue->title);
            }
            else
            {
                $outgoingMail->project_id = $this->project_id;
                $emailSender->setIssueNumber($this->number);
                $emailSender->setSubject($this->title);
            }
            $outgoingMail->object = serialize($emailSender);
            $outgoingMail->save();
        }     
    }
}

