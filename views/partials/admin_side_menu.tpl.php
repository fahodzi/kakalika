<?= $widgets->menu(
    array(
        array(
            'label' => 'Projects',
            'url' => u('admin/projects'),
            'default' => true
        ),
        array(
            'label' => 'Users',
            'url' => u('admin/users')
        )                    
    )
)->alias('side');
