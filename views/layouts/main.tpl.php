<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <title><?= ($title == '' ? '' : "$title | ") ?>Kakalika Issue Tracker</title>
        <?= $helpers->stylesheets
            ->add($helpers->listing->stylesheet())
            ->add('assets/css/main.css')
            ->add('assets/css/forms.css')
            ->add('assets/css/grid.css');
        ?>
        <?= $helpers->javascripts
            ->add('assets/js/mustache.js')
            ->add('assets/js/jquery.js')
            ->add('assets/js/kakalika.js')
        ?>
    </head>
    <body>
        <div id="wrapper">
            <div id="head" class="row">
                <div id="title_side" class="column grid_10_5">
                    <h1><a href="<?= u('/') ?>">Kakalika</a></h1>
                    <?php if(isset($project_name)): ?>
                    <h2><a href="<?= u($project_code) ?>"><?= $project_name ?></a></h2>
                    <?php endif; ?>
                </div>
                <div id="status_side" class="column grid_10_5">
                    <img src="<?= $helpers->social->gravatar($_SESSION['user']['email'])->size(53) ?>" />
                    <?php
                    $menu = array();
                    if($_SESSION['user']['is_admin'])
                    {
                        $menu[] = array(
                            'label' => 'Administration',
                            'url' => u('admin'),
                            'id' => 'menu-item-admin'
                        );
                    }                    
                    $menu[]= array(
                        'label' => 'Logout',
                        'url' => u('logout'),
                        'id' => 'menu-item-logout'
                    );
                    $menu[]= array(
                        'label' => "Account ⚫ {$_SESSION['user']['username']}",
                        'url' => u('account'),
                        'id' => 'menu-item-account'
                    );
                    ?>
                    
                    <?= $helpers->menu($menu)->setAlias('top') ?>
                </div>
            </div>
            <?php if($sub_section != ''): ?>
            <div id="sub_head">
                <div class="row">
                    <div class="column grid_10_7">
                        <h3><a href="<?= u(isset($sub_section_path) ? $sub_section_path : null) ?>"><?= $sub_section ?></a></h3>
                    </div>
                    <div class="column grid_10_3" align="right">
                        <?php 
                        if(count($sub_section_menu_sub_menu) > 0) echo $helpers->menu($sub_section_menu_sub_menu)->setAlias('sub-sub')->addCssClass('.hideable');
                        if(count($sub_section_menu) > 0) echo $helpers->menu($sub_section_menu)->setAlias('sub');
                        ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <?php if($install_active): ?>
            <div class="warning-banner">
                Your install directory is still accessible. For the security of your Kakalika installation please remove this directory or make it inaccessible to the web server.
            </div>            
            <?php endif; ?>            
            <div id="body">
                
                <?php if(isset($split)): ?>
                <div class="row">
                    <div class="column grid_10_7"><?= $contents->unescape() ?></div>
                    <div class="column grid_10_3"></div>
                </div>
                <?php else: ?>
                <?= $contents->unescape() ?>
                <?php endif; ?>
            </div>
            <div id="foot">
                <b>Kakalika</b> Issue Tracker. 
            </div>
        </div>
    </body>
</html>
<?php 

// Load icons
load_asset('images/logout.png');
load_asset('images/settings_small.png');
load_asset('images/account_small.png');
load_asset('images/add_project.png');
load_asset('images/add_issue.png');

load_asset('images/edit_small.png');
load_asset('images/delete_small.png');
load_asset('images/members_small.png');
load_asset('images/block_small.png');

load_asset('images/edit_big.png');
load_asset('images/watch.png');
load_asset('images/blue_tag.png');
load_asset('images/grey_tag.png');
load_asset('images/users.png');
load_asset('images/projects.png');
load_asset('images/block.png');

load_asset('images/add_user.png');
load_asset('images/add_milestone.png');
load_asset('images/add_component.png');

load_asset('images/memberships.png');
load_asset('images/delete_project.png');
load_asset('images/milestones.png');
load_asset('images/components.png');
load_asset('images/email.png');

load_asset('images/component_small.png');
load_asset('images/milestone_small.png');

load_asset('images/status_OPEN.png');
load_asset('images/status_CLOSED.png');
load_asset('images/status_RESOLVED.png');

load_asset('images/attachment.png');
load_asset('images/attached_file.png');
