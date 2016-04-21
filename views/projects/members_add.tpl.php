<?php 
$helpers->form->setErrors($errors); 
$helpers->form->setData($data);
?>
<?php
    echo $helpers->form->open() .
        $helpers->form->get_selection_list('Users', 'user_id')->setOptions($users->unescape()) .
        $helpers->form->close('Assign Member');
?>
