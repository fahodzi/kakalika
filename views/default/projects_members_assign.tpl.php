<h4><?= $title ?></h4>
<?php
$helpers->form->setErrors($errors);
?>
<div class="row">
    <div class="grid_10_7">
<?php
    echo $helpers->form->open() .
        $helpers->form->get_selection_list('Users', 'user_id')->options($users) .
        $helpers->form->close('Assign Member');
?>
    </div>
</div>