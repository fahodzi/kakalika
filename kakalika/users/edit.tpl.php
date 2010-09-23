<div class='body-menu'><?php echo $users_menu_block; ?></div>
<div id="body-contents">
<?php 
$form = $this->loadHelper("forms");
$form->add("TextField", "Full Name", "full_name","The fullname of the new user")->setRequired(true);
$form->add("EmailField", "Email", "email", "The email address of the new user")->setRequired(true);
$form->add("TextField", "Username", "username", "The login username of the new user")->setRequired(true);
$form->add("Checkbox", "Make Administrator?", "is_admin", "Should this user be allowed to administer the system","1");

$form->setErrors($errors);
$form->setData($data);

$form->submitValue = "Save";
echo $form;
?>
</div>
