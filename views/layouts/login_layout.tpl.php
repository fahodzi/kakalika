<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Kakalika Issue Tracker<?= ($title == '' ? '' : " - $title") ?></title>
        <?= $helpers->stylesheet
            ->add(load_asset('css/main.css'))
            ->add(load_asset('css/forms.css'))
            ->add(load_asset('css/grid.css'))
            ->context('login'); 
        ?>
    </head>
    <body>
            <div id="body">
                <?= $contents->unescape() ?>
            </div>
        </div>
    </body>
</html>
