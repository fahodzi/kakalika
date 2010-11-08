<?php
include "contents_frame_head.tpl.php";
$this->form->addModelField($fields["name"]);
$this->form->addModelField($fields["machine_name"]);
$this->form->addModelField($fields["description"]);
$this->form->submitValue = "Save";
$this->form->setData($data);
$this->form->setErrors($errors);
echo $this->form;
include "contents_frame_foot.tpl.php";
