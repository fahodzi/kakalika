<div class="row">
    <div class="column grid_10_7">
        <div class="p15">
        <?php
        $helpers->list->headers = array('Firstname', 'Lastname', 'username', '');
        $helpers->list->data = $members;
        $this->helpers->list->cellTemplates['id'] = 'projects_members_operations.tpl.php';
        echo $helpers->list;
        ?>
        </div>
    </div>
    <div class="column grid_10_3">
        <?=
        $widgets->menu(
            array(
                array(
                    'label' => 'Back to Projects',
                    'url' => u('admin/projects')
                )
            )
        )->alias('side');
        ?>
    </div>
</div>
