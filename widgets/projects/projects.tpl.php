<div id='projects-block' class='sidebox-block'>
<h4>Your Projects</h4>
<div id="projects-box">
<table class='sidebox-table'>
<?php foreach($projects as $project):?>
    <tr>
        <td class='projects-table-name'>
            <a href='<?php echo u($project["machine_name"])?>'>
                <?php echo $project["name"]?>
            </a>
        </td>
        <td class='projects-table-count'>7</td>
    </tr>
<?php endforeach;?>
</table>
</div>
</div>
