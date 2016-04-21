<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Kakalika Issue Tracker<?= ($title == '' ? '' : " - $title") ?></title>
        <?= $helpers->stylesheets
                ->add('assets/css/main.css')
                ->add('assets/css/forms.css')
                ->add('assets/css/grid.css')
                ->context('login'); 
        ?>
    </head>
    <body>
        <div id="body">
            <?= $contents->unescape() ?>
        </div>
    </body>
</html>
