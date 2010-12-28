<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <title><?php echo $title ?></title>
    <?php echo $stylesheets ?>
    <?php echo $javascripts ?>
</head>
<body>
<div id = "wrapper">
<div class="row" id="header" >
    <div class="column grid_20_15">
        <div id="title">
            <h1>Kakalika</h1>
            <h2><?php echo $main_section ?></h2>
        </div>
    </div>
    <div class="column grid_20_5">
        
    </div>
</div>
<div class="row" id="top-menu-row">
    <div class="column grid_20_15" id="top-menu">
        <?php echo $top_menu_widget ?>
    </div>
    <div class="column grid_20_5">
        <?php echo $search_widget ?>
    </div>
</div>
<div class="row">
    <div class="column grid_20_15" id="contents">
        <?php echo $contents?>
    </div>
    <div class="column grid_20_5" id="side">
        <?php echo $login_info_widget?>
        <?php echo $projects_widget?>
    </div>
</div>
<div class="row">
    <div class="column_grid_10_10" id="footer">Hello</div>
</div>
</div>
</body>
</html>