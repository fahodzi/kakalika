<div id='projects-block' class='sidebox-block'>
<h4>Your Projects</h4>
<div id="projects-box">
<table class='sidebox-table'>
<?php foreach($projects as $project):?>
    <tr>
        <td class='sidebox-table-item'><?php echo $project["name"]?></td>
        <td class='sidebox-table-count'>7</td>
    </tr>
<?php endforeach;?>
</table>
</div>
</div>
