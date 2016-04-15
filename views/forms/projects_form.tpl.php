<?php
$helpers->form->setData($project);
$helpers->form->setErrors($errors);
echo $helpers->form->open();
?>
<?php var_dump($project->getInvalidFields()) ?>
<div class="row">
    <div class="column grid_10_5">
        <div class="p15-right">
        <?=
        $helpers->form->get_text_field("Project's Name", 'name')
            ->setDescription("A name for the project").
        $helpers->form->get_text_field("Code", 'code')
            ->setDescription("A name to use for the projects url e.g. http://{$_SERVER['HTTP_HOST']}/shortname. No spaces, alpha numeric and underscores only.")
        ?>
        </div>
    </div>
    <div class="column grid_10_5">
        <div class="p1-right">
        <?= $helpers->form->get_text_area('A brief description', 'description') ?>
        </div>
    </div>
</div>
<?= $helpers->form->get_hidden_field('userId', $project->userId) ?>
<?= $helpers->form->get_hidden_field('id', $project->id) ?>
<?= $helpers->form->close('Save') ?>
