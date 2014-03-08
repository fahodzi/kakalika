<h4>Should <?= $item_name ?> <?= $item_type ?> be deleted?</h4>
<div class="row">
    <div class="column grid_10_7">
        <p>This operation cannot be reversed. Are you sure you really want to delete
         the <?= $item_type ?>, <b><?= $item_name ?>?</b>
        </p>
        <p>
            <a class="button redbutton" href="?confirm=yes">Yes, Delete</a>
            <a class="button greenbutton" href="../">No, Return to <?= $item_type ?> list</a>
        </p>
    </div>
    <div class="column grid_10_3">
        <?php 
        if($show_side){
            echo t("{$item_type}_side_menu.tpl.php", array('id' => $id));
        }
        ?>
    </div>
</div>
    