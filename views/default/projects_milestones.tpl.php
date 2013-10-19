<h4><?= $title ?></h4>
<div class="row">
    <div class="column grid_10_7">
        <div class="p15">
        <?php
            $helpers->list->headers = array('Milestone', '');
            $helpers->list->data = $milestones;
            $helpers->list->cellTemplates['id'] = 'projects_milestones_operations.tpl.php';
            $helpers->list->variables['id'] = $id;
            echo $helpers->list;
        ?>
        </div>
    </div>
    <div class="column grid_10_3">
        <?= t('project_side_menu.tpl.php', array('id' => $id))?>
    </div>
</div>
