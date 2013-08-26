<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Kakalika Issue Tracker<?= ($title == '' ? '' : " - $title") ?></title>
        <?= $helpers->stylesheet
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
                    <?= $widgets->menu(array('Administration', 'Account', 'Logout'))->alias('top') ?>
                </div>
            </div>
            <?php if($sub_section != ''): ?>
            <div id="sub_head">
                <h3><?= $sub_section ?></h3>
                <?php if(count($sub_section_menu) > 0){
                    echo $widgets->menu($sub_section_menu)->alias('sub');
                }?>
            </div>
            <?php endif; ?>
            <div id="body">
                
                <?php if($split): ?>
                <div class="row">
                    <div class="column grid_10_7"><?= $contents ?></div>
                    <div class="column grid_10_3"></div>
                </div>
                <?php else: ?>
                <?= $contents ?>
                <?php endif; ?>
            </div>
            <div id="foot"></div>
        </div>
    </body>
</html>
<?php 
load_asset('images/logout.png') ;
load_asset('images/settings_small.png') ;
load_asset('images/account_small.png') ;
?>