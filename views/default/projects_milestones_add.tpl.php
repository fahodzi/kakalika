<?=
$helpers->form->open().
$helpers->form->get_text_field('Name', 'name').
$helpers->form->get_text_area('Description', 'description').
$helpers->form->get_date_field('Due date', 'due_date').
$helpers->form->close('Save')
?>
        