<div class='issue_view'>
    <div id='title_block'><h4>#<?= $issue['number'] ?></h4> <h4><?= $issue['title'] ?></h4></div>
    <div class='row'>
        <div class='column grid_10_6'>
            <div style='padding:15px'><?= t('issue_slug.tpl.php', array('issue' => $issue)) ?></div>
            <p id='description'><?= $issue['description'] ?></p>        
        </div>
        <div class='column grid_10_4'>
            
        </div>
    </div>
</div>
