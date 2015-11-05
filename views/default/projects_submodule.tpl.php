<h4><?= $title ?></h4>
<div class="row">
    <div class="column grid_10_7">
        <div class="tool-section">
            <a href="<?= u($add_path) ?>" class="button greenbutton add-operation">
                <img src="<?= u(load_asset("images/add_{$item_type}.png")) ?>"/> Add a new <?= $item_type ?> to <?= $project ?>
            </a>
        </div>        
        <div class="p15">
        <?=
            $helpers->listing(
                array(
                    'headers' => array($item_type, ''),
                    'data' => $items,
                    'cell_templates' => ['id' => 'projects_submodule_operations.tpl.php'],
                    'variables' => array(
                        'id' => $id,
                        'module' => $module,
                        'disable_edit' => isset($disable_edit) ? $disable_edit : false
                    )
                )
            );
        ?>
        </div>
    </div>
    <div class="column grid_10_3">
        <?= t('project_side_menu.tpl.php', array('id' => $id))?>
    </div>
</div>
