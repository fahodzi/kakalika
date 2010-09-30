<?php 
$gravatar = $this->loadHelper("gravatar");
?>
<div id='profile-box' class='small-shadow rounded-5px'>
    <img src='<?php echo $gravatar->get($user["email"])?>' alt='[Avatar]' />
    <div>
        <?php echo $user["full_name"] ?><br/>
        <a href='<?php echo $logout_path?>'>Logout</a>
    </div>
    <div class='clearer'></div>
</div>