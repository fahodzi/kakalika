<?php if($admin): ?>

    <div class="row">
        <div class="column grid_10_7">
            <div class="p15">
            <?php
            $helpers->list->headers = array('Name', '');
            $helpers->list->data = $projects;
            $this->helpers->list->cellTemplates['id'] = 'projects_run_operations.tpl.php';
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

    <?php foreach($projects as $project): ?>
    <div class="project-info-wrapper">
    <div class="row">
        <div class="column grid_10_4">
            <a href="<?= u($project['project']['code']) ?>" class="project-name"><?= $project['project']['name'] ?></a>
            <span class="project-desc"><?= $project['project']['description'] ?></span>
        </div>
        <div class="column grid_10_2">
            <a class="tinylink" href="<?= u("{$project['project']['code']}/edit") ?>">
                <img src="<?= u(load_asset('images/edit_small.png'))?>" alt="edit" /> Edit
            </a>
        </div>
        <div class="column grid_10_4">
            Resolved Open
        </div>
    </div>
    </div>
    <?php endforeach; ?>

<?php endif; ?>