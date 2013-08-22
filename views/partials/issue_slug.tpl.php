<span class="issue_slug">
    Opened by <img src="<?= $helpers->gravatar->image($issue['opener']['email'])->size(16) ?>" /> 
    <b><?= "{$issue['opener']['lastname']} {$issue['opener']['firstname']} " ?></b>
    <?= $helpers->date($issue['created'])->sentence(array('elaborate_with' => 'ago')) ?>.
    <?php if(isset($issue['assignee_details'])): ?>
    Assigned to <b>James Ainooson</b>
    <?php endif; ?>
</span>
