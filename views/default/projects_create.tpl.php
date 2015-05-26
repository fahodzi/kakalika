<h4>Create a new project</h4>
<div class="row">
    <div class="column grid_10_7">
        <?= t('projects_form.tpl.php', array('project' => $project, 'errors' => $errors))  ?>
    </div>
    <div class="column grid_10_3">
        <?php
        if($admin){
            echo $helpers->menu(
                array(
                    array(
                        'label' => 'Return to Projects list',
                        'url' => u("admin/projects"),
                    )
                )                    
            )->setAlias('side');
        }
        ?>
    </div>
</div>
