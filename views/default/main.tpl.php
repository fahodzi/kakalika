<!DOCTYPE html>
<html lang="en">
    <head>
    <?= $helpers->stylesheet->add(load_asset('css/main.css')); ?>
    <?= $helpers->stylesheet->add(load_asset('css/main.css')); ?>
    <?= $helpers->stylesheet->add(load_asset('css/forms.css')); ?>
    </head>
    <body>
        <div id="wrapper">
            <div id="head"><h1>Kakalika</h1></div>
            <div id="body">
                <?= $contents ?>
            </div>
            <div id="foot"></div>
        </div>
    </body>
</html>
