<h4><?= $title ?></h4>
<div class="row">
<div class="column grid_10_8">
<?php 
$helpers->form->setData($user);
$helpers->form->setErrors($errors);
?>
<?= $helpers->form->open() ?>
<div class="row" style="width:100%">
    <div class="column grid_10_5">
        <?=
            $helpers->form->open_fieldset("Personal Information") .
            $helpers->form->get_text_field('Firstname', 'firstname')->setDescription('Your real firstname for easy identification') .
            $helpers->form->get_text_field('Lastname', 'lastname')->setDescription('Optional lastname') .
            $helpers->form->get_text_field('Username', 'username')->setDescription('Note that the username you select must be unique') .
            $helpers->form->get_text_field('Email', 'email')->setDescription("Your email address is also used for your avatar. Visit <a href='gravatar.com'>gravatar.com</a> to setup your avatar.") .
            $helpers->form->close_fieldset() 
        ?>
    </div>
    <div class="column grid_10_5">
        <?=
            $helpers->form->open_field_set("Password") .
            $helpers->form->get_password_field('New Password', 'password') .
            $helpers->form->get_password_field('Repeat New Password', 'repeat_password') .
            $helpers->form->close_fieldset() 
        ?>
        
        <?=
            $helpers->form->open_field_set("Account Details") .
            $helpers->form->get_checkbox('User is administrator', 'is_admin') .
            $helpers->form->close_fieldset()
        ?>
    </div>
</div>
<?= $helpers->form->close("Add User") ?>
</div></div>
