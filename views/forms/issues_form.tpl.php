<?php 
$helpers->form->setData($data);
$helpers->form->setErrors($errors);
?>
<?= $helpers->form->open()->attribute('enctype', 'multipart/form-data') ?>
<div class="row">
    <div class="column grid_10_7">
        <div style="padding-right:15px">
        <?= 
        $helpers->form->get_text_field('Title', 'title')->addCssClass('title') . 
        $helpers->form->get_text_area('Description', 'description')->id('description') 
        ?>
        <?php if($comment) echo $helpers->form->get_text_area('Comment', 'comment') ?>
            <div class="attachment-box">
                <div id="issue-attachments"></div>
                <span id="attachment-link" class="link" onclick="kakalika.addUploadField()">Add Attachment</span>
            </div>
        </div>
    </div>
    <div class="column grid_10_3">
        <div style="padding-right:1px">
        <?=
        $helpers->form->get_selection_list('Assignee', 'assignee')->options($assignees) .
        $helpers->form->get_selection_list('Kind', 'kind')
            ->option('Bug', 'BUG')
            ->option('Enhancement', 'ENHANCEMENT')
            ->option('Proposal', 'PROPOSAL')
            ->option('Question', 'QUESTION')
            ->option('Task', 'TASK'). 
        $helpers->form->get_selection_list('Priority', 'priority')
            ->option('Trivial', 'TRIVIAL')
            ->option('Low', 'LOW')
            ->option('Medium', 'MEDIUM')       
            ->option('High', 'HIGH')
            ->option('Critical', 'CRITICAL')
            ->option('Blocker', 'BLOCKER').
        $helpers->form->get_selection_list('Component', 'component_id')->options($components).
        $helpers->form->get_selection_list('Milestone', 'milestone_id')->options($milestones)
        ?>
        </div>
    </div>
</div>
<script type="text/html" id="upload-field">
<?= $helpers->form->get_upload_field('', 'attachment[]') ?>    
</script>
