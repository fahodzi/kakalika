<?php 
$sub_section = "Edit User";
include "contents_frame_head.tpl.php";
$form = $this->loadHelper("forms");
$form->add("TextField", "Full Name", "full_name","The fullname of the new user")->setRequired(true);
$form->add("EmailField", "Email", "email", "The email address of the new user")->setRequired(true);
$form->add("TextField", "Username", "username", "The login username of the new user")->setRequired(true);
$form->add("Checkbox", "Make Administrator?", "is_admin", "Should this user be allowed to administer the system","1");

$form->setErrors($errors);
$form->setData($data);

$form->submitValue = "Save";
echo $form;
include "contents_frame_foot.tpl.php";