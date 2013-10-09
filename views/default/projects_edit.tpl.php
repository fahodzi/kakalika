<h4><?= $title ?></h4>
<div class="row">
    <div class="column grid_10_7">
    <?= t('projects_form.tpl.php', array('project' => $project, 'errors' => $errors))  ?>
    </div>
    <div class="column grid_10_3">
    <?= t('project_side_menu.tpl.php', array('id' => $project['id']))?>
    </div>
</div>
