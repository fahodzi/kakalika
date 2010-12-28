<div class="row" id="header">
    <div class="column grid_10"><h1>Kakalika</h1></div>
</div>
<div id='login-box'>
<h2>Login</h2>
<?php
echo $login_message;
echo $this->form->open('login-form');
echo $this->form->get_text_field("Username", "username");
echo $this->form->get_password_field("Password", "password");
echo $this->form->close("Login");
?>
</div>
