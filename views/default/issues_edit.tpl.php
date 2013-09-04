<h4><?= $title ?></h4>
<?php 
$form_data['assignee'] = (int) $form_data['assignee'];
$helpers->form->setData($form_data);
?>
<?= $helpers->form->open() ?>
<div class="row">
    <div class="column grid_10_7">
        <div style="padding-right:15px">
        <?= 
            $helpers->form->get_text_field('Title', 'title') . 
            $helpers->form->get_text_area('Description', 'description')->id('description') .
            $helpers->form->get_text_area('Comment', 'comment')
        ?>
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
            ->option('Blocker', 'BLOCKER')
        
        ?>
        </div>
    </div>
</div>

<?= $helpers->form->close('Update Issue') ?>
