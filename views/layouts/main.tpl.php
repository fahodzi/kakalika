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
                    <?php
                    $menu = array();
                    if($_SESSION['user']['is_admin'])
                    {
                        $menu[] = array(
                            'label' => 'Administration',
                            'url' => u('admin')
                        );
                    }
                    
                    $menu[]= 'Account';
                    $menu[]= 'Logout';
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
                        <?php if(count($sub_section_menu) > 0){
                            echo $widgets->menu($sub_section_menu)->alias('sub');
                        }?>
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

load_asset('images/edit_issue.png');
load_asset('images/white_tag.png');
load_asset('images/grey_tag.png');
load_asset('images/users.png');
load_asset('images/projects.png');
load_asset('images/block.png');

load_asset('images/add_user.png');
load_asset('images/memberships.png');
load_asset('images/assign_member.png');
load_asset('images/delete_project.png');
?>