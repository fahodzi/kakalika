<h3>Create a new Issue</h3>
<?php 
$helpers->form->setData($data);
$helpers->form->setErrors($errors);
?>
<?= $helpers->form->open() ?>
<div class="row">
    <div class="column grid_10_7">
        <div style="padding-right:15px">
        <?= $helpers->form->get_text_field('Title', 'title') . $helpers->form->get_text_area('Description', 'description')->id('description') ?>
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
            ->option('Task', 'TASK'). 
        $helpers->form->get_selection_list('Priority', 'priority')
            ->option('Trivial', 'TRIVIAL')
            ->option('Minor', 'MINOR')
            ->option('Normal', 'NORMAL')
            ->option('Major', 'MAJOR')
            ->option('Critical', 'CRITICAL')
        ?>
        </div>
    </div>
</div>

<?= $helpers->form->close('Create Issue') ?>
