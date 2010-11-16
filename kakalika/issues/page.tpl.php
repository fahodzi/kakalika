<?php 
include "contents_frame_head.tpl.php";
$cell_templates['priority'] = 'priorities_cell.tpl.php';
$cell_templates['created'] = 'date_cell.tpl.php';
$cell_templates['last_updated'] = 'date_cell.tpl.php';
$variables = array(
    "item_operation_url" => $item_operation_url
);
$headers = array("Status", "Issue", "Assigned To", "Priority");
include n("controllers/components/admin/templates/page.tpl.php");
include "contents_frame_foot.tpl.php";
