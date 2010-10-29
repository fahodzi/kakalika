<?php 
$this->forms->add_model_field("Select new user", "users", "full_name");
$this->forms->add_checkbox("Make user a project administrator?", "is_admin");
$this->forms->setData($_POST);
$this->forms->setErrors($errors);
echo $this->forms;
