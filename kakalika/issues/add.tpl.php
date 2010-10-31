<?php 
use kakalika\issues\Issues;
include "contents_frame_head.tpl.php";
$this->forms->setData($_POST);
$this->forms->setErrors($errors);
echo $this->forms->open() 
?>
<div class="row" style="width:100%">
    <div class="column grid_10_7">
        <div style='padding-right:10px'>
            <?php 
            echo $this->forms->get_text_field("Title", "title");
            echo $this->forms->get_text_area("Description", "description");
            echo $this->forms->open_field_set("Attachments");
            echo $this->forms->get_upload_field("","files");
            echo $this->forms->close_field_set();
            ?>
        </div>
    </div>
    <div class="column grid_10_3">
        <div style="padding-left:5px; padding-right:5px">
            <?php 
            $assignees = array();
            foreach($project_users as $project_user)
            {
                $assignees[$project_user["user"]["id"]] = $project_user["user"]["full_name"];
            }
            $assignees_list = $this->forms->get_selection_list("Assign this issue to", "assignee")->setOptions($assignees);
            echo $assignees_list;
            
            $types_list = $this->forms->get_selection_list("What type of issue is it", "type");
            foreach(Issues::$types as $type)
            {
                $types_list->addOption($type);
            }
            echo $types_list;
            
            $priorities_list = $this->forms->get_selection_list("What's the priority of the issue","priority");
            foreach(Issues::$priorities as $priority)
            {
                $priorities_list->addOption($priority);
            }
            echo $priorities_list;            
            echo $this->forms->get_text_area("Tags", "tags")
                ->addAttribute("style", "height:100px")
                ->setDescription("Use a comma separated list of tags");
            ?>
        </div>
    </div>
</div>
<?php 
echo $this->forms->close(); 
include "contents_frame_foot.tpl.php";
?>
