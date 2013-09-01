<h3>Delete <?= $item_name ?> <?= $item_type ?></h3>
<p>This operation cannot be reversed. Are you sure you really want to delete
 the <?= $item_type ?>, <b><?= $item_name ?>?</b>
</p>
<p>
    <a class="button" href="?confirm=yes">Yes, Delete</a>
    <a class="button" href="../">No, Return to <?= $item_type ?> list</a>
</p>