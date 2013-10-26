<h4><?= $title ?></h4>
<div class="row">
    <div class="column grid_10_7">
        <?= t("projects_{$module}_edit.tpl.php", array('data' => $data)) ?>
    </div>
    <div class="column grid_10_3">
        <?= t('project_side_menu.tpl.php', array('id' => $id))?>
    </div>
</div>