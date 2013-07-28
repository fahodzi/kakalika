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
                    <h1>Kakalika</h1>
                    <?php if($project_name != ''): ?>
                    <h2><?= $project_name ?></h2>
                    <?php endif; ?>
                    <div id="header_menu">
                        <?= $widgets->menu(array('Projects'))->alias('main') ?>
                    </div>                    
                </div>
                <div id="status_side" class="column grid_10_5">
                    <?= $widgets->menu(array('Administration', 'Account Settings', 'Logout')) ?>
                </div>
            </div>
            <?php if($sub_section != ''): ?>
            <div id="sub_head">
                <h2><?= $sub_section ?></h2>
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
