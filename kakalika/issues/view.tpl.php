<?php
use kakalika\issues\Issues;
include "contents_frame_head.tpl.php";
$this->form->setData($issue);
?>
<div class="row" style="width:100%; border-bottom:1px solid #f0f0f0">
    <div class="column grid_20_13">
        <div class="issue-summary">
            Created <?php echo $this->date->sentence($issue["created"], array('elaborate_with' => 'ago')); ?> by
            <?php echo $issue["created_by"]["full_name"]; ?>
        </div>
        <div style='padding-right:10px'>
            <p><?php echo $issue['description'] ?></p>
        </div>
    </div>
    <div class="column grid_20_7">
        <div style="padding-left:5px; padding-right:5px">
            <div class="issue-attribute">
                <div class="issue-attribute-title">Assigned To</div>
                <div class="issue-attribute-value"><?php echo $issue["assigned_to"]["full_name"] ?></div>
            </div>
            <div class="issue-attribute">
                <div class="issue-attribute-title">Type</div>
                <div class="issue-attribute-value"><?php echo $issue["type"] ?></div>
            </div>
            <div class="issue-attribute">
                <div class="issue-attribute-title">Priority</div>
                <div class="issue-attribute-value"><?php echo $issue["priority"] ?></div>
            </div>
            <div class="issue-attribute">
                <div class="issue-attribute-title">Created On</div>
                <div class="issue-attribute-value"><?php echo $issue["created"] ?></div>
            </div>
            <div class="issue-attribute">
                <div class="issue-attribute-title">Updated On</div>
                <div class="issue-attribute-value"><?php echo $issue["last_updated"] ?></div>
            </div>
            <div class="issue-attribute">
                <div class="issue-attribute-title">Tags</div>
                <div class="issue-attribute-value">
                    <?php foreach($issue["tags"] as $tag):?>
                    <span class="issue-tag"><?php echo $tag['tag'] ?></span>
                    <?php endforeach;?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->form->open() ?>
<div class="row" style="width:100%">
    <div class="column grid_10_6">
        <div style="padding-left:5px; padding-right:5px">
            <?php echo $this->form->get_text_area("Comment", "comment") ?>
        </div>
    </div>
    <div class="column grid_10_4">
        <div style="padding-left:5px; padding-right:5px">
            <?php
            $assignees = array();
            foreach($project_users as $project_user)
            {
                $assignees[$project_user["user"]["id"]] = $project_user["user"]["full_name"];
            }
            $assignees_list = $this->form->get_selection_list("Re-assign this issue to", "assigned_to")->setOptions($assignees);
            echo $assignees_list;

            $types_list = $this->form->get_selection_list("What type of issue is it", "type");
            foreach(Issues::$types as $type)
            {
                $types_list->addOption($type);
            }
            echo $types_list;

            $priorities_list = $this->form->get_selection_list("What's the priority of the issue","priority");
            foreach(Issues::$priorities as $priority)
            {
                $priorities_list->addOption($priority);
            }
            echo $priorities_list;
            echo $this->form->get_text_area("Tags", "tags")
                ->addAttribute("style", "height:100px")
                ->setDescription("Use a comma separated list of tags");
            echo $this->form->get_upload_field("Attachment", "files");
            ?>
        </div>
    </div>
</div>
<?php echo $this->form->close() ?>
<?php include 'contents_frame_foot.tpl.php' ?>
