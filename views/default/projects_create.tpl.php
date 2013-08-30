<h3>Create a new project</h3>
<?php
$helpers->form->setData($project);
$helpers->form->setErrors($errors);
?>
<?=
$helpers->form->open() .
$helpers->form->get_text_field("Project's Name", 'name') .
$helpers->form->get_text_field("Code", 'code')
    ->description("A name to use for the projects url e.g. http://{$_SERVER['HTTP_HOST']}/shortname. No spaces, alpha numeric and underscores only.") .
$helpers->form->get_text_area('A brief description', 'description') .
$helpers->form->close('Create Project')
?>
