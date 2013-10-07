<h4>Create a new project</h4>
<div class="row">
    <div class="column grid_10_7">
        <?php
        $helpers->form->setData($project);
        $helpers->form->setErrors($errors);
        ?>
        <?=
        $helpers->form->open() .
        $helpers->form->get_text_field("Project's Name", 'name')->addCssClass('title') .
        $helpers->form->get_text_field("Code", 'code')
            ->description("A name to use for the projects url e.g. http://{$_SERVER['HTTP_HOST']}/shortname. No spaces, alpha numeric and underscores only.") .
        $helpers->form->get_text_area('A brief description', 'description') .
        $helpers->form->close('Create Project')
        ?>
    </div>
    <div class="column grid_10_3">
        <?php
        if($admin){
            echo $widgets->menu(
                array(
                    array(
                        'label' => 'Return to Projects list',
                        'url' => u("admin/projects"),
                    )
                )                    
            )->alias('side');
        }
        ?>
    </div>
</div>