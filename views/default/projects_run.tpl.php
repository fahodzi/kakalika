<?php if($admin): ?>
<h4>List of projects</h4>    
    <div class="row">
        <div class="column grid_10_7">
            <div class="p15">
            <?php
            $helpers->list->headers = array('Name', '');
            $helpers->list->data = $projects;
            $helpers->list->cellTemplates['id'] = 'projects_run_operations.tpl.php';
            
            echo $helpers->list;
            ?>
            </div>
        </div>    
        <div class="column grid_10_3"><?= t('admin_side_menu.tpl.php') ?></div>
    </div>

<?php else: ?>
<table class="project-info-list">
    <?php foreach($projects as $project): ?>
    <tr class="project-info-wrapper">
        <td>
            <a href="<?= u($project['project']['code']) ?>" class="project-name"><?= $project['project']['name'] ?></a>
            <span class="project-desc"><?= $this->truncate($project['project']['description'], 30) ?></span>            
        </td>
        <td style="text-align: center">
            <a class="edit-operation tinylink " href="<?= u("{$project['project']['code']}/edit") ?>">Edit</a>
        </td>
        <td style="text-align:right">
            <div class="issue-counter">
                <span class="open label"><?= $project['open'] ?></span>&nbsp;
                <a href='<?= u($project['project']['code']) ?>?filter=open'>Open</a>
            </div>
            <div class="issue-counter">
                <span class="resolved label"><?= $project['resolved'] ?></span>&nbsp;
                <a href='<?= u($project['project']['code']) ?>?filter=resolved'>Resolved</a>
            </div>            
            <div class="issue-counter">
                <span class="mine label"><?= $project['my_open'] ?></span>&nbsp;
                <a href='<?= u($project['project']['code']) ?>?filter=mine'>Mine</a>
            </div>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php endif; ?>