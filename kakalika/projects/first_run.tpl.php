<?php 
$gravatar = $this->loadHelper("gravatar");
?>
<h4>Add users to <?php echo $name?></h4>
<p>
Apart from you, there are currently no users assigned to <?php echo $name?>.
Please select the other members of this project from the list below. If you are
the only member of this project, you might as well submit the form without
selecting any other users.
</p>
<form action="" method="POST">
<div id='users-list' class='small-scroll-box'>
<table>
<?php foreach($users as $user):?>
<tr>
    <td><input type="checkbox" name="user_ids[]" value="<?php echo $user["id"]?>" /></td>
    <td><img src="<?php echo $gravatar->get($user["email"])?>" alt="<?php echo $user["username"]?>" /></td>
    <td><span class='dark-grey'><?php echo $user["full_name"]?></span><br/>
        <span class='grey'><?php echo $user["email"]?></span>
    </td>
</tr>
<?php endforeach;?>
</table>
</div>
<div class='fapi-submit-area'>
    <input type='submit' value='Assign Users'/>
</div>
<input type="hidden" name="form_submitted" value="yes" />
</form>
