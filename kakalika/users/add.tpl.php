<?php
$sub_section = "Add new User";
include "contents_frame_head.tpl.php"; 
$this->forms->add("TextField", "Full Name", "full_name","The fullname of the new user")->setRequired(true);
$this->forms->add("EmailField", "Email", "email", "The email address of the new user")->setRequired(true);
$this->forms->add("TextField", "Username", "username", "The login username of the new user")->setRequired(true);
$this->forms->add("PasswordField", "Password", "password")->setRequired(true);
$this->forms->add("PasswordField", "Retype Password", "password_2")->setRequired(true);
$this->forms->add("Checkbox", "Make Administrator?", "is_admin", "Should this user be allowed to administer the system","1");
$this->forms->setErrors($errors);
$this->forms->setData($data);

$this->forms->submitValue = "Save";
echo $this->forms;
include "contents_frame_foot.tpl.php";
