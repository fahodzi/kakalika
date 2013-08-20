<div class="row">
    <div class="column grid_20_15">
        <?php foreach($issues as $issue): ?>
        <div class="issue_summary">
            <div class="row" style="width:100%">
                <div class="column grid_20_1"><span class="issue_id">#<?= $issue['number'] ?></span></div>
                <div class="column grid_20_15">
                    <span class="issue_title"><?= $issue['title'] ?></span>
                    <span class="issue_slug">
                        Opened by <b><?= "{$issue['user']['lastname']} {$issue['user']['firstname']} " ?></b>
                        <?= $helpers->date($issue['created'])->sentence(array('elaborate_with' => 'ago')) ?>.
                        Assigned to <b>James Ainooson</b>
                    </span>
                </div>
                <div class="column grid_20_4">
                    <span>High</span>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <div class="column grid_20_5">
        
    </div>
</div>