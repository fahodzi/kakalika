<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <title><?php echo $title ?></title>
    <?php echo $stylesheets ?>
    <?php echo $javascripts ?>
</head>
<body>
<div class="row" id="header" >
    <div class="column grid_10_7">
        <div id="title">
            <h1>Kakalika</h1>
            <h2>Administration</h2>
        </div>
    </div>
    <div class="column grid_10_3">
        Login Info<?php echo $login_info_block?>
    </div>
</div>
<div class="row">
    <div class="column grid_10_10" id="top-menu">
    <?php echo $top_menu_block ?>
    </div>
</div>
<div class="row">
    <div class="column grid_10_7" id="contents">
        <div id="body" class="big-allround-shadow">
            <h3 class='dark-grey-gradient'><?php echo $section ?></h3>
            <div class='body-menu grey-gradient'><?php echo $sub_menu_block; ?></div>
            <?php if(isset($_GET["n"])):?>
            <div class='notification'><?php echo $_GET["n"]?></div>
            <?php endif?>            
            <div id='body-contents'>
                <?php echo $contents?>
            </div>
        </div>
    </div>
    <div class="column grid_10_3" id="side">Side blocks</div>
</div>
<div class="row">
    <div class="column_grid_10_10" id="footer">Hello</div>
</div>
</body>
</html>