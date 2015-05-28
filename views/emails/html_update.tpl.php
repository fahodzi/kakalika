<div style="font-family: sans">
<div style="color:#c0c0c0; border-bottom: 1px solid #c0c0c0; padding-bottom: 5px; font-size:x-small">Reply above this line to comment on this issue</div>
<br/>
<p>
    <?= nl2br($message) ?>
</p>
<?php if($changes['assignee'] != '' || $changes['priority'] != '' || $changes['kind'] != '' || $changes['status'] != '' || $changes['milestone_id'] || $changes['component_id']): ?>

<br/>
<div style="background-color: #fafafa; color:#808080; font-size: smaller; padding:10px">
<ul>
<?php
    $messages = array();

    if($changes['assignee']['id'] != '') 
        $messages[] = "Assigned <span class='name'>{$changes['assignee']['firstname']} {$changes['assignee']['lastname']}</span> to this issue";

    if($changes['priority'] != '')
        $messages[] = "Set priority to <b>{$changes['priority']}</b>";

    if($changes['kind'] != '')
        $messages[] = "Marked issue as <b>{$changes['kind']}</b>";

    if($changes['status'] != '')
        $messages[] = "<b>{$changes['status']}</b> this issue";

    if($changes['milestone_id'] != '')
        $messages[] = "Set milestone to <b>{$changes['milestone']['name']}</b>";

    if($changes['component_id'] != '')
        $messages[] = "Set component as <b>{$changes['component']['name']}</b>";
?>
<?php foreach($messages as $message): ?>
    <li><?= $message ?></li>
<?php endforeach; ?>
</ul>
</div>

<?php endif; ?>

<br/>
<p style="color:#c0c0c0; font-size: x-small">Powered by <b>Kakalika Issue Tracker</b></p>
</div>
