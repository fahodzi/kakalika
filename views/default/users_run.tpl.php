<div class="row">
    <div class="column grid_10_7">
        <h3>List of users</h3>
        <div class="p15">
        <?php
        $helpers->list->headers = array('Firstname', 'Lastname', 'Username', 'Email', '');
        $helpers->list->data = $users;
        $this->helpers->list->cellTemplates['id'] = 'users_run_operations.tpl.php';
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

