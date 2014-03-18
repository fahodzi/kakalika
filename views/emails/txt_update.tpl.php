---- Reply above this line to comment on this issue ----


<?= $message ?>

<?php if($changes['assignee'] != '' || $changes['priority'] != '' || $changes['kind'] != '' || $changes['status'] != '' || $changes['milestone_id'] || $changes['component_id']): ?>

The following change(s) were made to this issue.
<?php
    $messages = array();

    if($changes['assignee']['id'] != '') 
        $messages[] = "Assigned {$changes['assignee']['firstname']} {$changes['assignee']['lastname']} to this issue";

    if($changes['priority'] != '')
        $messages[] = "Set priority to {$changes['priority']}";

    if($changes['kind'] != '')
        $messages[] = "Marked issue as {$changes['kind']}";

    if($changes['status'] != '')
        $messages[] = "{$changes['status']} this issue";

    if($changes['milestone_id'] != '')
        $messages[] = "Set milestone to {$changes['milestone']['name']}";

    if($changes['component_id'] != '')
        $messages[] = "Set component as {$changes['component']['name']}";
?>
<?php foreach($messages as $message): ?>
   • <?= $message ?>
<?php endforeach; ?>
<?php endif; ?>


Powered by Kakalika Issue Tracker
