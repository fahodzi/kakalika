<span class="issue_slug">
    Opened by 
    <b><?= "{$issue['opener']['lastname']} {$issue['opener']['firstname']} " ?></b>
    <?= $helpers->date($issue['created'])->sentence(array('elaborate_with' => 'ago')) ?>
    
    <?php if($issue['assignee']['id'] != ''): ?>
    ⚫ Assigned to 
    <b><?= "{$issue['assignee']['lastname']} {$issue['assignee']['firstname']} " ?></b>
    <?php endif; ?>

    <?php if($issue['updater']['id'] != ''): ?>
    ⚫ Updated by 
    <b><?= "{$issue['updater']['lastname']} {$issue['updater']['firstname']} " ?></b>
    <?= $helpers->date($issue['updated'])->sentence(array('elaborate_with' => 'ago')) ?>
    <?php endif; ?>    
</span>
