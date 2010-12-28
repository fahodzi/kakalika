<?php
$sub_section = "Add new User";
include "contents_frame_head.tpl.php";
echo $this->forms->open();
echo $this->forms->get_text_field("Full Name", "full_name","The fullname of the new user")->setRequired(true);
echo $this->forms->get_text_field("Email", "email", "The email address of the new user")->setRequired(true);
echo $this->forms->get_text_field("Username", "username", "The login username of the new user")->setRequired(true);
echo $this->forms->get_password_field("Password", "password")->setRequired(true);
echo $this->forms->get_password_field("Retype Password", "password_2")->setRequired(true);
echo $this->forms->get_checkbox("Make Administrator?", "is_admin", "Should this user be allowed to administer the system","1");
$this->forms->setErrors($errors);
$this->forms->setData($data);
echo $this->forms->close("Save");

include "contents_frame_foot.tpl.php";
