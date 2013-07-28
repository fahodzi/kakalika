<h3>Create a new Issue</h3>
<?= $helpers->form->open() ?>
<div class="row">
    <div class="column grid_10_7">
        <div style="padding-right:15px">
        <?= $helpers->form->get_text_field('Title', 'title') . $helpers->form->get_text_area('Description', 'description') ?>
        </div>
    </div>
    <div class="column grid_10_3">
        <div style="padding-right:1px">
        <?=
        $helpers->form->get_selection_list('Assignee', 'assignee')->options($assignees) .
        $helpers->form->get_selection_list('Kind', 'kind') . 
        $helpers->form->get_selection_list('Priority', 'priority')
        ?>
        </div>
    </div>
</div>

<?= $helpers->form->close('Create Issue') ?>
