<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?= ($title == '' ? '' : "$title | ") ?>Kakalika Issue Tracker</title>
        <?= $helpers->stylesheet
            ->add(load_asset('css/list.css', n('lib/views/helpers/lists/css/default.css')))
            ->add(load_asset('css/main.css'))
            ->add(load_asset('css/forms.css'))
            ->add(load_asset('css/grid.css'));
        ?>
        <?= $helpers->javascript
            ->add(load_asset('js/mustache.js'))
            ->add(load_asset('js/jquery.js'))
            ->add(load_asset('js/kakalika.js'))
        ?>
    </head>
    <body>
        <div id="wrapper">
            <div id="head" class="row">
                <div id="title_side" class="column grid_10_5">
                    <h1><a href="<?= u('') ?>">Kakalika</a></h1>
                    <?php if($project_name != ''): ?>
                    <h2><a href="<?= u($project_code) ?>"><?= $project_name ?></a></h2>
                    <?php endif; ?>
                </div>
                <div id="status_side" class="column grid_10_5">
                    <img src="<?= $helpers->gravatar->image($_SESSION['user']['email'])->size(53) ?>" />
                    <?php
                    $menu = array();
                    if($_SESSION['user']['is_admin'])
                    {
                        $menu[] = array(
                            'label' => 'Administration',
                            'url' => u('admin')
                        );
                    }                    
                    $menu[]= 'Logout';
                    $menu[]= array(
                        'label' => "Account ⚫ {$_SESSION['user']['username']}",
                        'url' => u('account')
                    );
                    ?>
                    
                    <?= $widgets->menu($menu)->alias('top') ?>
                </div>
            </div>
            <?php if($sub_section != ''): ?>
            <div id="sub_head">
                <div class="row">
                    <div class="column grid_10_7">
                        <h3><a href="<?= u($sub_section_path) ?>"><?= $sub_section ?></a></h3>
                    </div>
                    <div class="column grid_10_3" align="right">
                        <?php 
                        if(count($sub_section_menu_sub_menu) > 0) echo $widgets->menu($sub_section_menu_sub_menu)->alias('sub-sub')->addCssClass('.hideable');
                        if(count($sub_section_menu) > 0) echo $widgets->menu($sub_section_menu)->alias('sub');
                        ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <div id="body">
                
                <?php if($split): ?>
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
