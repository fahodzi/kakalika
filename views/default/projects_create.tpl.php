<h3>Create a new project</h3>
<?=
$helpers->form->open() .
$helpers->form->get_text_field("Project's Name", 'name') .
$helpers->form->get_text_area('A brief description') .
$helpers->form->close('Create Project')
?>