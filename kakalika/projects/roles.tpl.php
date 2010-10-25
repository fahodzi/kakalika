<h4>Setup <?php echo $project ?> Roles </h4>
<div class='body-menu grey-gradient'><?php echo $roles_menu_block; ?></div>
<?php foreach($roles as $role):?>
<div class='rounded-5px role-permission-block'>
    <span class='title'><?php echo $role["name"] ?></span>
</div>
<?php endforeach?>
