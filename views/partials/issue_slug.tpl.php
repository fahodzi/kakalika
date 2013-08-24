<span class="issue_slug">
    Opened by <img src="<?= $helpers->gravatar->image($issue['opener']['email'])->size(16) ?>" /> 
    <b><?= "{$issue['opener']['lastname']} {$issue['opener']['firstname']} " ?></b>
    <?= $helpers->date($issue['created'])->sentence(array('elaborate_with' => 'ago')) ?>.
    
    <?php if($issue['assignee']['id'] != ''): ?>
    Assigned to <img src="<?= $helpers->gravatar->image($issue['assignee']['email'])->size(16) ?>" /> 
    <b><?= "{$issue['assignee']['lastname']} {$issue['assignee']['firstname']} " ?></b>
    <?php endif; ?>
</span>
