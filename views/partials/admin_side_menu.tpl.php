<?= $helpers->menu(
    array(
        array(
            'label' => 'Projects',
            'url' => u('admin/projects'),
            'id' => 'menu-item-admin-projects',
            'default' => true
        ),
        array(
            'label' => 'Users',
            'id' => 'menu-item-admin-users',
            'url' => u('admin/users')
        )                    
    )
)->setAlias('side');
