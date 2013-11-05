<?php 
$helpers->form->setErrors($errors); 
$helpers->form->setData($data);
?>
<?php
    echo $helpers->form->open() .
        $helpers->form->get_selection_list('Users', 'user_id')->options($users) .
        $helpers->form->close('Assign Member');
?>
