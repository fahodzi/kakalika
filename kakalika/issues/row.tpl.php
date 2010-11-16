<tr onmouseover="$(this).addClass('mouseover')"
    onmouseout="$(this).removeClass('mouseover')"
    onclick="document.location='<?php echo $variables['item_operation_url'] ?>/<?php echo $row['id'] ?>'" >
    <td>
        <?php echo $row['status']; ?>
    </td>
    <td>
        <div><?php echo $row['title'] ?></div>
        <div style="font-size:smaller; color:#808080">
            <?php echo $row['type'] ?> created
            <?php echo $this->date->sentence($row['created'], array('elaborate_with' => 'ago')) ?>
            by <?php echo $row['created_by'] ?>
        </div>
    </td>
    <td><?php echo $row['assigned_to'] ?></td>
    <td><?php echo $row['priority'] ?></td>
    <td></td>
</tr>
