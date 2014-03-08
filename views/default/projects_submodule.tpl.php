<h4><?= $title ?></h4>
<div class="row">
    <div class="column grid_10_7">
        <div class="tool-section">
            <a href="<?= u($add_path) ?>" class="button greenbutton add-operation">
                <img src="<?= u(load_asset("images/add_{$item_type}.png")) ?>"/> Add a new <?= $item_type ?> to <?= $project ?>
            </a>
        </div>        
        <div class="p15">
        <?php
            $helpers->list->headers = array($item_type, '');
            $helpers->list->data = $items;
            $helpers->list->cellTemplates['id'] = 'projects_submodule_operations.tpl.php';
            $helpers->list->variables = array(
                'id' => $id,
                'module' => $module,
                'disable_edit' => $disable_edit
            );
            echo $helpers->list;
        ?>
        </div>
    </div>
    <div class="column grid_10_3">
        <?= t('project_side_menu.tpl.php', array('id' => $id))?>
    </div>
</div>
