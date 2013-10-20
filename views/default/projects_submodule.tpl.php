<h4><?= $title ?></h4>
<div class="row">
    <div class="column grid_10_7">
        <div class="p15">
        <?php
            $helpers->list->headers = array('Milestone', '');
            $helpers->list->data = $milestones;
            $helpers->list->cellTemplates['id'] = 'projects_submodule_operations.tpl.php';
            $helpers->list->variables = array(
                'id' => $id,
                'module' => $module,
            );
            echo $helpers->list;
        ?>
        </div>
    </div>
    <div class="column grid_10_3">
        <?= t('project_side_menu.tpl.php', array('id' => $id))?>
    </div>
</div>
