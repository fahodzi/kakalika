<div id='members-list'>
<?php foreach($users as $user): ?>
<div style="width:290px;float:left;margin:5px;padding:5px;background:#f8f8f8" class="rounded-5px">
    <img style="float:left;margin:5px" src='<?php echo $this->gravatar->get($user["user"]["email"])?>' alt='avatar'/>
    <div style="float:left;margin:5px">
        <span class="feed-clickable"><?php echo $user["user"]["full_name"]?></span><br/>
        <span style="color:#404040"><?php echo $user["user"]["email"]?></span><br/>
        <span style="color:#808080"><?php echo $user["is_admin"] == 1 ? "Administrator" : "Member"?></span>
    </div>
    <div style="float:right; margin:5px">
        <a href='<?php echo u("admin/projects/members/{$project_id}/delete/{$user["id"]}")?>'>X</a>
    </div>
    <div style="clear:both"></div>
</div>
<?php endforeach;?>
<div style="clear:both"></div>
</div>