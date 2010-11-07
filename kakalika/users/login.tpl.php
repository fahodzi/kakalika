<div class="row" id="header">
    <div class="column grid_10"><h1>Kakalika</h1></div>
</div>
<div id='login-box'>
<h2>Login</h2>
<?php
echo $login_message;
$this->form->add("TextField", "Username", "username");
$this->form->add("PasswordField", "Password", "password");
$this->form->id = "login-form";
$this->form->submitValue = "Login";
echo $this->form;
?>
</div>
