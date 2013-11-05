<?php $helpers->form->setData($data);?>
<?=
$helpers->form->open().
$helpers->form->get_text_field('Name', 'name').
$helpers->form->get_text_area('Description', 'description').
$helpers->form->close('Save')
?>
        
