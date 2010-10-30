<?php
namespace kakalika\issues;

use ntentan\models\Model;

class IssuesModel extends Model
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
    
    public static $types = array(
        IssuesModel::TYPE_ERROR,
        IssuesModel::TYPE_FEATURE_REQUEST,
        IssuesModel::TYPE_INQUIRY
    );
    
    public static $statuses = array(
        IssuesModel::STATUS_NEW,
        IssuesModel::STATUS_OPEN,
        IssuesModel::STATUS_CLOSED,
        IssuesModel::STATUS_INVALID,
        IssuesModel::STATUS_PENDING
    );
    
    public static $priorities = array(
        IssuesModel::PRIORITY_EMERGENCY,
        IssuesModel::PRIORITY_HIGH,
        IssuesModel::PRIORITY_MEDIUM,
        IssuesModel::PRIORITY_LOW
    );
    
    public $belongsTo = array(
        array("user", "as" => "creator"),
        array("user", "as" => "assignee")
    );
}