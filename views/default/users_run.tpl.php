<h4>List of users</h4>
<div class="row">
    <div class="column grid_10_7">
        <div class="p15">
        <?php
        $helpers->list->headers = array('Firstname', 'Lastname', 'Username', 'Email', '');
        $helpers->list->data = $users;
        $this->helpers->list->cellTemplates['id'] = 'users_run_operations.tpl.php';
        echo $helpers->list;
        ?>
        </div>
    </div>
    <div class="column grid_10_3"><?= t('admin_side_menu.tpl.php') ?></div>
</div>

