<h4><?= $title ?></h4>
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
    </div>
    <div class="column grid_20_5">
        
    </div>
</div>