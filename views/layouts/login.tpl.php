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
                </div>
            </div>
            <div id="body">
                <?= $contents ?>
            </div>
            <div id="foot"></div>
        </div>
    </body>
</html>
