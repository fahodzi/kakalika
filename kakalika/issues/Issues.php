<?php
namespace kakalika\issues;

use ntentan\models\Model;

class Issues extends Model
{
    const TYPE_ERROR = 'Error';
    const TYPE_FEATURE_REQUEST = 'Feature Request';
    const TYPE_INQUIRY = 'Inquiry';
    
    const STATUS_NEW = 'New';
    const STATUS_OPEN = 'Open';
    const STATUS_CLOSED = 'Closed';
    const STATUS_INVALID = 'Invalid';
    const STATUS_PENDING = 'Pending';
    
    const PRIORITY_LOW = "Low";
    const PRIORITY_MEDIUM = "Medium";
    const PRIORITY_HIGH = "High";
    const PRIORITY_EMERGENCY = "Emergency";
    
    private $tagsArray = array();
    
    public static $types = array(
        Issues::TYPE_ERROR,
        Issues::TYPE_FEATURE_REQUEST,
        Issues::TYPE_INQUIRY
    );
    
    public static $statuses = array(
        Issues::STATUS_NEW,
        Issues::STATUS_OPEN,
        Issues::STATUS_CLOSED,
        Issues::STATUS_INVALID,
        Issues::STATUS_PENDING
    );
    
    public static $priorities = array(
        Issues::PRIORITY_EMERGENCY,
        Issues::PRIORITY_HIGH,
        Issues::PRIORITY_MEDIUM,
        Issues::PRIORITY_LOW
    );
    
    public $belongsTo = array(
        array("user", "as" => "created_by"),
        array("user", "as" => "assigned_to"),
        "project"
    );

    public $hasMany = array(
        "tags"
    );
    
    public function preSaveCallback()
    {
        $this->tagsArray = explode(",", $this->data["tags"]);
        unset($this->data["tags"]);
        unset($this->data["files"]);
    }
    
    public function postSaveCallback($id)
    {
        if(count($this->tagsArray) > 0)
        {
            $tags = Model::load("tags");
            foreach($this->tagsArray as $tag)
            {
                $tags->tag = trim($tag);
                $tags->issue_id = $id;
                $tags->save();
            }
        }
    }
}
