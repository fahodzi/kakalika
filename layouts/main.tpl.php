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
        <?php echo $top_menu_block ?>
    </div>
    <div class="column grid_20_5">
        <?php echo $search_block ?>
    </div>
</div>
<div class="row">
    <div class="column grid_20_15" id="contents">
        <div id="body" class="big-allround-shadow">
            <?php if($section!=""):?>
            <h3 class='dark-grey-gradient'><?php echo $section ?></h3>
            <?php endif;?>
            <?php if($sub_section!=""):?>
            <h4><?php echo $sub_section?></h4>
            <?php endif;?>
            <div class='body-menu grey-gradient'><?php echo $sub_menu_block; ?></div>
            <?php if(isset($_GET["n"])):?>
                <div class='notification'>
                <?php 
                    switch($notification_type)
                    {
                    case 1:
                        echo "Successfully added $model <b>$notification_item</b>";
                        break;
                    case 2:
                        echo "Successfully edited $model <b>$notification_item</b>";
                        break;
                    case 3:
                        echo "Successfully deleted $model <b>$notification_item</b>";
                        break;
                    }
                ?>
                </div>
            <?php endif?>
            <div id='body-contents'>
                <?php echo $contents?>
            </div>
        </div>
    </div>
    <div class="column grid_20_5" id="side">
        <?php echo $login_info_block?>
        <?php echo $projects_block?>
    </div>
</div>
<div class="row">
    <div class="column_grid_10_10" id="footer">Hello</div>
</div>
</div>
</body>
</html>