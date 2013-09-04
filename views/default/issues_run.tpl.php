<h4><?= $title ?></h4>
<table class='issues_list'>
    <?php foreach($issues as $issue): ?>
    <tr class='issue_summary'>
        <td><div class="issue_id">#<?= $issue['number'] ?></div></td>
        <td><div class="<?= strtolower($issue['status']) ?> issue-status"><?= $issue['status'] ?></td>
        <td>
            <div class="issue_details">
            <span class="issue_title">
                <a class="<?= strtolower($issue['status']) ?>-link" href='<?= u("{$project_code}/issues/{$issue['number']}") ?>'><?= $issue['title'] ?></a>
            </span>
            <?= t('issue_slug.tpl.php', array('issue' => $issue)) ?>
            </div>                    
        </td>
        <td>
            <div style="padding-left:10px; border-left:2px solid #f0f0f0; margin:10px">
            <?php if($issue['priority'] != ''): ?>
            <div class="issues-tag">
                <img src="<?= u(load_asset("images/priority_{$issue['priority']}.png")) ?>" /> <?= ucfirst(strtolower($issue['priority'])) ?>
            </div>
            <?php endif; ?>
            
            <?php if($issue['kind'] != ''): ?>
            <div class="issues-tag">
                <img src="<?= u(load_asset("images/kind_{$issue['kind']}.png")) ?>" /> <?= ucfirst(strtolower($issue['kind'])) ?>
            </div>
            <?php endif; ?>
            <br/>
            <?php if($issue['number_of_updates'] > 0): ?>
            <div class="issues-tag comments">Comments <?= $issue['number_of_updates'] ?></div>
            <?php endif; ?>   
            </div>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
