<span class="issue_slug">
    Opened by 
    <b><?= "{$issue->opened_by}" ?></b>
    <?= $helpers->date($issue['created'])->sentence(array('elaborate_with' => 'ago')) ?>
    
    <?php if($issue['assignee'] != ''): ?>
    ⚫ Assigned to 
    <b><?= "{$issue->assigned_to} " ?></b>
    <?php endif; ?>

    <?php if($issue['updater'] != ''): ?>
    ⚫ Updated by 
    <b><?= "{$issue->updated_by} " ?></b>
    <?= $helpers->date($issue['updated'])->sentence(array('elaborate_with' => 'ago')) ?>
    <?php endif; ?>    
</span>
