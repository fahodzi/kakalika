<?php
$gravatar = $this->loadHelper("gravatar");
$time = $this->loadHelper("time");
$previousDate = null;
?>
<table id='feed'>
<?php foreach($feed_items as $feed_item):?>
<?php
$timeObject = $time->parse($feed_item["time"]);
$friendlyTime = $timeObject->friendly();
?>
<?php if($timeObject->friendly() != $previousDate):?>
<tr class='feed-head'>
    <td colspan="4">
        <?php 
        echo $friendlyTime;
        $previousDate = $friendlyTime;
        ?>
    </td>
</tr>
<?php endif; ?>
<tr class='feed-item'>
    <td><div class='feed-time rounded-5px feed-tag'><?php echo $timeObject->time()?></div></td>
    <td><img class='feed-avatar' src="<?php echo $gravatar->get($feed_item["user"]["email"], 48)?>" alt="user" /></td>
    <td><div class='feed-text'><?php echo getDescription($feed_item, $gravatar)?></div></td>
    <td><?php echo getItemType($feed_item)?></td>
</tr>
<?php endforeach;?>
</table>

<?php
function getDescription($feed_item, $gravatar)
{
    switch($feed_item["activity"])
    {
    case "CREATED_PROJECT":
        return "<span class='feed-clickable'>{$feed_item["user"]["full_name"]}</span>" .
               " created a new project <span class='feed-clickable'>{$feed_item["project"]["name"]}</span>";
    case "USER_ADDED_TO_PROJECT":
        $data = json_decode($feed_item["data"], true);
        $avatar = $gravatar->get($data["email"], 16);
        return "<span class='feed-clickable'>{$feed_item["user"]["full_name"]}</span>" .
               " added <img src='$avatar' />" . 
               "<span class='feed-clickable'>{$data["full_name"]}</span> to " . 
               "<span class='feed-clickable'>{$feed_item["project"]["name"]}</span>";
    case 'USER_REMOVED_FROM_PROJECT':
        $data = json_decode($feed_item["data"], true);
        $avatar = $gravatar->get($data["email"], 16);
        return "<span class='feed-clickable'>{$feed_item["user"]["full_name"]}</span>" .
               " removed <img src='$avatar' />" . 
               "<span class='feed-clickable'>{$data["full_name"]}</span> from " . 
               "<span class='feed-clickable'>{$feed_item["project"]["name"]}</span>";
    }
}

function getItemType($feed_item)
{
    switch($feed_item["activity"])
    {
    case "CREATED_PROJECT":
        return "<div class='feed-project-tag feed-tag rounded-5px'>Project</div>";
    case "USER_ADDED_TO_PROJECT":
        return "<div class='feed-project-tag feed-tag rounded-5px'>Project</div>";
    }
}
?>