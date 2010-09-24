<?php
$form = $this->loadHelper("forms");
$form->addModelField($fields["name"]);
$form->addModelField($fields["machine_name"]);
$form->addModelField($fields["description"]);
$form->submitValue = "Save";
$form->setData($data);
$form->setErrors($errors);
echo $form;
