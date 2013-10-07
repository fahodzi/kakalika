<h4><?= $title ?></h4>
<div class="row">
    <div class="column grid_10_7">
        <div class="p15">
        <?php
        $helpers->list->headers = array('Firstname', 'Lastname', 'username', '');
        $helpers->list->data = $members;
        $helpers->list->cellTemplates['id'] = 'projects_members_operations.tpl.php';
        $helpers->list->variables['id'] = $id;
        echo $helpers->list;
        ?>
        </div>
    </div>
    <div class="column grid_10_3">
        <?= t('project_side_menu.tpl.php', array('id' => $id))?>
    </div>
</div>
