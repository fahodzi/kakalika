<?php 
$gravatar = $this->loadHelper("gravatar");
?>
<div id='profile-box' class='rounded-5px big-allround-shadow'>
    <img id='profile-pic' src='<?php echo $gravatar->get($user["email"], 64)?>' alt='[Avatar]' />
    <div id='profile-info'>
        <div id='profile-name'><?php echo $user["full_name"] ?></div>
        <div id='profile-links'>
            <a href='<?php echo $logout_path?>'>Logout</a>
        </div>
    </div>
    <div class='clearer'></div>
</div>