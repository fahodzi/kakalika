<?php
namespace kakalika\modules\issues;

use ntentan\Model;
use kakalika\modules\watchers\Watchers;
use ntentan\Session;
use kakalika\modules\updates\Updates;
use kakalika\modules\issue_attachments\IssueAttachments;
use kakalika\modules\projects\Projects;

class Issues extends Model
{
    public $belongsTo = array(
        ['user', 'local_key' => 'opener', 'as' => 'opened_by'],
        ['user', 'local_key' => 'assignee', 'as' => 'assigned_to'],
        ['user', 'local_key' => 'updater', 'as' => 'updated_by'],
        'project',
        'milestone',
        'component'
    );
    
    public $hasMany = array(
        'updates', 'issue_attachments', 'watchers'
    );
    
    public $behaviours = array(
        'timestampable'
    );
    
    private $originalIssue;
    private $updateData = array();
    private $attachments = array();
    
    public function addAttachment($attachment)
    {
        $this->attachments[] = $attachment;
    }
    
    public function comment($comment)
    {
        
    }
    
    public function preUpdateCallback() 
    {
        if($this->updater == '') Session::get('user')['id'];
        $this->originalIssue = self::createNew()->fetchFirstWithId($this->id);//->toArray();
        
        if($this->comment != '') 
        {
            $this->updateData['comment'] = $this->comment;
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
        
        unset($this['comment']);    
        
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
            $update = Updates::createNew();
            $update->setData($this->updateData);
            $update->updateIssue = false;
            $update->save(); 
            
            $this->addWatcher($this->updater);
            $this->addWatcher($this->assignee);
                        
            foreach($this->attachments as $attachment)
            {
                $issueAttachment = IssueAttachments::createNew();
                $issueAttachment->issue_id = $this->id;
                $issueAttachment->attachment_file = $attachment['file'];
                $issueAttachment->name = $attachment['name'];
                $issueAttachment->type = $attachment['type'];
                $issueAttachment->user_id = Session::get('user')['id'];
                $issueAttachment->size = $attachment['size'];
                $issueAttachment->update_id = $update->id;
                $issueAttachment->save();
            }
        }
                
        $this->notify(
            isset($this->updateData['comment']) ? $this->updateData['comment'] : null, 
            $this->updateData
        );
    }
    
    public function preSaveCallback()
    {
        $this->status = 'OPEN';
        if(isset(Session::get('user')['id'])) 
        {
            $this->opener = Session::get('user')['id'];
        }
        if($this->assignee != '')
        {
            $this->assigned = date('Y-m-d H:i:s');
        }
    }
    
    public function addWatcher($userId, $toggle = false)
    {
        $watcher = Watchers::fetchFirst(['issue_id' => $this->id, 'user_id' => $userId]);
        if($watcher->count() == 0)
        {
            $watcher->user_id = $userId;
            $watcher->issue_id = $this->id;
            $watcher->save();
        } elseif ($toggle) {
            $watcher->delete();
        }
    }
    
    public function postSaveCallback($id) 
    {
        $project = Projects::fetchFirstWithId($this->project_id);
        $this->number = ++$project->number_of_issues;
        $project->save();
        
        $this->addWatcher($this->opener);
        
        if($this->assignee != '' && $this->assignee != $this->opener)
        {
            $this->addWatcher($this->assignee);
        }
        
        foreach($this->attachments as $attachment)
        {
            $issueAttachment = IssueAttachments::createNew();
            $issueAttachment->issue_id = $id;
            $issueAttachment->attachment_file = $attachment['file'];
            $issueAttachment->name = $attachment['name'];
            $issueAttachment->type = $attachment['type'];
            $issueAttachment->user_id = $_SESSION['user']['id'];
            $issueAttachment->size = $attachment['size'];
            $issueAttachment->save();
        }
        
        $this->notify($this->description);
    }
    
    public function notify($message, $changes = array())    
    {
        $watchers = Watchers::filter('issue_id = ? AND user_id <> ?', [$this->id, Session::get('user')['id']])->fetch();
        
        foreach($watchers as $watcher)
        {
            $watcher = $watcher->toArray(1);
            
            $emailSender = new \kakalika\lib\EmailSender();
            $emailSender->setDestination($watcher['user']['email'], "{$watcher['user']['firstname']} {$watcher['user']['lastname']}");
            $emailSender->setMessage($message);
            $emailSender->setChanges($changes);
            $source = Session::get('user');
            $emailSender->setSource(sprintf(
                    '%s %s', $source['firstname'], $source['lastname']
                )
            );            
            $outgoingMail = \kakalika\modules\outgoing_mails\OutgoingMails::createNew();
            
            if($this->project_id == '' || $this->number == '' || $this->tite == '')
            {
                $issue = Issues::createNew()->fields('project_id', 'number', 'title')->fetchFirstWithId($this->id);
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
            
            foreach($this->attachments as $attachment)
            {
                $emailSender->addAttachment($attachment['file'], $attachment['name']);
            }
            
            $outgoingMail->object = serialize($emailSender);
            $outgoingMail->save();
        }     
    }
}
