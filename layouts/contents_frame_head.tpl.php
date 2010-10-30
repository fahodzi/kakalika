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
