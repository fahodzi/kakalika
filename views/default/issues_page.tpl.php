<div id="tool-header">
    <div class="row">
        <div class="column grid_10_5"><h4><?= $title ?></h4></div>
        <div class="column grid_10_5" style="text-align:right">
            <img src="<?= load_asset('images/sort.png') ?>" />
            <select onchange="document.location='?sorter=' + this.value + ('<?= $filter ?>' != '' ? '&filter=<?= $filter ?>' : '')">
                <option></option>
                <?php foreach($sorters as $sort => $label): ?>
                <option value="<?= $sort ?>" <?= $sort === $sorter->unescape() ? "selected='selected'" : "" ?> ><?= $label ?></option>
                <?php endforeach; ?>
            </select>            
            <img src="<?= load_asset('images/filter.png') ?>" />
            <select onchange="document.location='?filter=' + this.value + ('<?= $sorter ?>' != '' ? '&sorter=<?= $sorter ?>' : '')">
                <option></option>
                <?php foreach($filters as $item => $label): ?>
                <option value="<?= $item ?>" <?= $filter->unescape() === $item ? "selected='selected'" : "" ?> ><?= $label ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
</div>
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
            <?php if($issue['number_of_updates'] > 0): ?>
            <div class="issues-tag">
                <img src="<?= load_asset("images/comment.png") ?>" /> <?= $issue['number_of_updates'] ?>
            </div>
            <?php endif; ?>   
            <?php if($issue['priority'] != ''): ?>
            <div class="issues-tag">
                <img src="<?= load_asset("images/priority_{$issue['priority']}.png") ?>" /> <?= ucfirst(strtolower($issue['priority'])) ?>
            </div>
            <?php endif; ?>
            <?php if($issue['kind'] != ''): ?>
            <div class="issues-tag">
                <img src="<?= load_asset("images/kind_{$issue['kind']}.png") ?>" /> <?= ucfirst(strtolower($issue['kind'])) ?>
            </div>
            <?php endif; ?>
            </div>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php if($number_of_pages > 1){
        echo $helpers->pagination(
        array(
            'page_number' => $page_number, 
            'number_of_pages' => $number_of_pages, 
            'base_route' => $base_route,
            'query' => 'page'
        )
    );
}
?>
