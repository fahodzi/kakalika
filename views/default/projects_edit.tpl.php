<h3>Edit project</h3>
<?php 
$helpers->form->setData($project);
$helpers->form->setErrors($errors);
?>
<?=
$helpers->form->open() .
$helpers->form->get_text_field("Project's Name", 'name') .
$helpers->form->get_text_field("Code", 'code')
    ->description("Please note that changing this would cause the URL of your project to also change.") .
$helpers->form->get_text_area('A brief description', 'description') .
$helpers->form->close('Update Project')
?>
