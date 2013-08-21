<span class="issue_slug">
    Opened by <b><?= "{$issue['user']['lastname']} {$issue['user']['firstname']} " ?></b>
    <?= $helpers->date($issue['created'])->sentence(array('elaborate_with' => 'ago')) ?>.
    <?php if($issue['assignee'] != ''): ?>
    Assigned to <b>James Ainooson</b>
    <?php else: ?>
    <b>Unassigned</b>
    <?php endif; ?>
</span>