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
    
    public $hasMany = array('updates');
    
    public $behaviours = array(
        'timestampable'
    );
    
    private $originalIssue;
    private $updateData = array();
    
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
            $update->save();
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
}
