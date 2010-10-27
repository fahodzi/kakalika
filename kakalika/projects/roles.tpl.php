<h4>Setup <?php echo $project ?> Roles </h4>
<div class='body-menu grey-gradient'><?php echo $roles_menu_block; ?></div>
<?php foreach($roles as $role):?>
<div class='rounded-5px role-permission-block'>
    <span class='title'><?php echo $role["name"] ?></span>
    <?php foreach($permission_groups as $label => $permission_group):?>
    <fieldset>
    <legend><?php echo s($label)?></legend>
    <?php foreach($permission_group as $permission):?>
    <table>
        <tr>
            <td><input type="checkbox" name='<?php echo $permission?>' value='1'/></td>
            <td><?php echo s($permission)?></td>
        </tr>
    </table>
    <?php endforeach;?>
    </fieldset>
    <?php endforeach;?>
</div>
<?php endforeach?>
