<?= $widgets->menu(
    array(
        array(
            'label' => 'Project Details',
            'url' => u("admin/projects/edit/$id"),
            'id' => 'menu-item-admin-projects-edit'
        ),
        array(
            'label' => 'Components',
            'url' => u("admin/projects/components/$id"),
            'id' => 'menu-item-admin-projects-components'
        ),
        array(
            'label' => 'Milestones',
            'url' => u("admin/projects/milestones/$id"),
            'id' => 'menu-item-admin-projects-milestones'
        ),
        array(
            'label' => 'Project Members',
            'url' => u("admin/projects/members/$id"),
            'id' => 'menu-item-admin-projects-members'
        ),
        array(
            'label' => 'Email Integration',
            'url' => u("admin/projects/email/$id"),
            'id' => 'menu-item-admin-projects-email'
        ),        
        array(
            'label' => 'Delete Project',
            'url' => u("admin/projects/delete/$id"),
            'id' => 'menu-item-admin-projects-delete'
        ),
        array(
            'label' => 'Return to Projects',
            'url' => u("admin/projects")
        )
    )
)->alias('side');        