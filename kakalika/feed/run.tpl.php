<?php 
$gravatar = $this->loadHelper("gravatar");
$time = $this->loadHelper("time");
$previousDate = null;
?>
<table>
<?php foreach($feed_items as $feed_item):?>
<?php 
$timeObject = $time->parse($feed_item["time"]);
$friendlyTime = $timeObject->friendly(); 
?>
<?php if($timeObject->friendly() != $previousDate):?>
<tr><td colspan="3"><?php echo $friendlyTime ?></td></tr>
<?php endif; ?>
<tr>
    <td><?php echo $timeObject->time()?></td>
    <td><img src="<?php echo $gravatar->get($feed_item["user"]["email"], 48)?>" alt="user" /></td>
    <td><?php echo getDescription($feed_item)?></td>
</tr>
<?php endforeach;?>
</table>
<?php 
function getDescription($feed_item)
{
    switch($feed_item["activity"])
    {
    case "CREATED_PROJECT":
        return "<span class='feed-username'>{$feed_item["user"]["full_name"]}</span> 
            created a new project <span class='feed-projectname'>{$feed_item["project"]["name"]}</span>";
    }
}
?>