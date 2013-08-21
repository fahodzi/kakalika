<?php var_dump(\ntentan\Ntentan::$requestedRoute) ?>

<div class="row">
    <div class="column grid_20_15">
        <table class='issues_list'>
            <?php foreach($issues as $issue): ?>
            <tr class='issue_summary'>
                <td><div class="issue_id">#<?= $issue['number'] ?></div></td>
                <td>
                    <div class="issue_details">
                    <span class="issue_title">
                        <a href='<?= u("{$project_code}/issues/{$issue['number']}") ?>'><?= $issue['title'] ?></a>
                    </span>
                    <?= t('issue_slug.tpl.php', array('issue' => $issue)) ?>
                    </div>                    
                </td>
                <td>
                    
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        
        <!--
        <?php foreach($issues as $issue): ?>
        <div class="issue_summary">
            <div class="row" style="width:100%">
                <div class="column grid_20_1"><div class="issue_id">#<?= $issue['number'] ?></div></div>
                <div class="column grid_20_15">
                    <div class="issue_details">
                    <span class="issue_title"><?= $issue['title'] ?></span>
                    <span class="issue_slug">
                        Opened by <b><?= "{$issue['user']['lastname']} {$issue['user']['firstname']} " ?></b>
                        <?= $helpers->date($issue['created'])->sentence(array('elaborate_with' => 'ago')) ?>.
                        Assigned to <b>James Ainooson</b>
                    </span>
                    </div>
                </div>
                <div class="column grid_20_4">
                    <span>High</span>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        -->
    </div>
    <div class="column grid_20_5">
        
    </div>
</div>