<h4>Add new Issue</h4>
<?php echo $this->forms->open() ?>
<div class="row" style="width:100%">
    <div class="column grid_10_7">
        <div style='padding-right:10px'>
            <?php 
            echo $this->forms->get_text_field("Title");
            echo $this->forms->get_text_area("Description");
            echo $this->forms->get_text_field("Tags");
            ?>
        </div>
    </div>
    <div class="column grid_10_3">
        <div style="padding-left:5px; padding-right:5px">
            <?php 
            echo $this->forms->get($fields["assignee"], "Assign this issue to");
            echo $this->forms->get_selection_list("Type");
            echo $this->forms->get_selection_list("Priority");
            ?>
        </div>
    </div>
</div>
<?php echo $this->forms->close() ?>
