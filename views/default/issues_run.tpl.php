<?php foreach($issues as $issue): ?>
<div class="issue_summary">
    <div class="row">
        <div class="column grid_20_1"><span class="issue_id">#<?= $issue['number'] ?></span></div>
        <div class="column grid_20_15">
            <span class="issue_title"><?= $issue['title'] ?></span>
            <span class="issue_slug">Opened by <?= "{$issue['user']['lastname']} {$issue['user']['firstname']} " ?><?= $helpers->date($issue['created'])->sentence(array('elaborate_with' => 'ago')) ?></span>
        </div>
    </div>

</div>
<?php endforeach; ?>

