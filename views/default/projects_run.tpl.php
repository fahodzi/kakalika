<h4>List of projects</h4>
<?php if($admin): ?>
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
        <div class="column grid_10_3">
            <?=
            $widgets->menu(
                array(
                    array(
                        'label' => 'Users',
                        'url' => u('admin/users')
                    ),
                    array(
                        'label' => 'Projects',
                        'url' => u('admin/projects')
                    )
                )
            )->alias('side');
            ?>
        </div>
    </div>

<?php else: ?>
<table class="project-info-list">
    <?php foreach($projects as $project): ?>
    <tr class="project-info-wrapper">
        <td>
            <a href="<?= u($project['project']['code']) ?>" class="project-name"><?= $project['project']['name'] ?></a>
            <span class="project-desc"><?= $this->truncate($project['project']['description'], 40) ?></span>            
        </td>
        <td>
            <a class="edit-operation tinylink " href="<?= u("{$project['project']['code']}/edit") ?>">Edit</a>
        </td>
        <td>
            <div class="issue-counter"><span class="open label"><?= $project['open'] ?></span>&nbsp;Open</div>
            <div class="issue-counter"><span class="resolved label"><?= $project['resolved'] ?></span>&nbsp;Resolved</div>            
        </td>
        <td>
            <div class="issue-counter"><span class="mine label"><?= $project['my_open'] ?></span>&nbsp;Mine</div>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php endif; ?>