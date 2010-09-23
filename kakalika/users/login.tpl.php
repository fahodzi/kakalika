<div class="row" id="header">
    <div class="column grid_10"><h1>Kakalika</h1></div>
</div>
<div id='login-box'>
<h2>Login</h2>
<?php
echo $login_message;
$loginform = $this->loadHelper("forms");
$loginform->add("TextField", "Username", "username");
$loginform->add("PasswordField", "Password", "password");
$loginform->id = "login-form";
$loginform->submitValue = "Login";
echo $loginform;
?>
</div>
