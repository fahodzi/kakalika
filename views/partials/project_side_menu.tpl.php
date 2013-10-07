<?= $widgets->menu(
    array(
        array(
            'label' => 'Edit Project Details',
            'url' => u("admin/projects/edit/$id"),
            'id' => 'menu-item-admin-projects-edit'
        ),
        array(
            'label' => 'Edit Project Members',
            'url' => u("admin/projects/members/$id"),
            'id' => 'menu-item-admin-projects-members'
        ),
        array(
            'label' => 'Delete Project',
            'url' => u("admin/projects/delete/$id"),
            'id' => 'menu-item-admin-projects-delete'
        ),
        array(
            'label' => 'Return to Projects list',
            'url' => u("admin/projects")
        )
    )
)->alias('side');        