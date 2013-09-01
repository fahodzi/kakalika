<div class="row">
    <div class="column grid_10_7">
<h3>Edit <?= $project['name'] ?> project</h3>
<?php 

$helpers->form->setData($project);
$helpers->form->setErrors($errors);
?>
<?=
$helpers->form->open() .
$helpers->form->get_text_field("Project's Name", 'name') .
$helpers->form->get_text_field("Code", 'code')
    ->description("Please note that changing this would cause the URL of your project to also change.") .
$helpers->form->get_text_area('A brief description', 'description') .
$helpers->form->close('Update Project')
?>
    </div>
    <div class="column grid_10_3">
    <?php 
    if($admin){
        echo $widgets->menu(
            array(
                array(
                    'label' => 'Edit Project Members',
                    'url' => u("admin/projects/members/{$project['id']}")
                ),
                array(
                    'label' => 'Delete Project',
                    'url' => u("admin/projects/delete/{$project['id']}")
                ),
                array(
                    'label' => 'Return to Projects list',
                    'url' => u("admin/projects")
                )
            )
        )->alias('side');        
    }
    ?>
    </div>
</div>
