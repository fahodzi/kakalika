<div class='issue_view'>
    <div id='title_block'>
        <div class="row">
            <div class="column grid_10_7"><h4>#<?= $issue['number'] ?></h4> <h4><?= $issue['title'] ?></h4></div>
            <div class="column grid_10_3">
                <?= $widgets->menu(
                    array(
                        array(
                            'label' => 'Edit',
                            'url' => u("{$project_code}/issues/edit/7")
                        ),
                        array(
                            'label' => 'Close',
                            'url' => u("{$project_code}/issues/close/7")
                        ),
                        array(
                            'label' => 'Delete',
                            'url' => u("{$project_code}/issues/delete/7")
                        )
                    )
                )
                ?>
            </div>
        </div>
    </div>
    <div class='row'>
        <div class='column grid_10_7 issue_view_content'>
            <div style='padding:15px'><?= t('issue_slug.tpl.php', array('issue' => $issue)) ?></div>
            <p id='description'><?= $this->nl2br($issue['description']) ?></p>  
            
            <h5>Comments (<?= count($issue['updates']) ?>)</h5>
            
            <?php $stripe = true; foreach($issue['updates'] as $update): ?>
            <div class="update <?= $stripe ? 'striped' : '' ?>">
                <img src="<?= $helpers->gravatar->image($update['user']['email'])->size(32) ?>" />
                <span class="name"><?= $update['user']['firstname'] . " " . $update['user']['lastname'] ?></span>
                <div class="small-date"><?= $helpers->date($update['created'])->sentence(array('elaborate_with' => 'ago')) ?> ⚫ <?= $helpers->date($update['created'])->format('jS F, Y @ g:i a') ?></div>
                <p><?= $update['comment'] ?></p>
            </div>
            
            <?php $stripe = !$stripe; endforeach; ?>
            <?= 
                $helpers->form->open() .
                $helpers->form->get_text_area('Comment', 'comment') .
                $helpers->form->close('Post Comment') 
            ?>
        </div>
        <div class='column grid_10_3 issue_view_side'>
            <div>
                <h5>Details</h5>
                <dl>
                    <dt>Status</dt>
                    <dd><?= $issue['status'] ?></dd>
                    <dt>Kind</dt>
                    <dd><?= $issue['kind'] ?></dd>
                    <dt>Priority</dt>
                    <dd><?= $issue['priority'] ?></dd>
                </dl>
                <h5>People</h5>
                
                <div class='people-info'>
                    <img src='<?= $helpers->gravatar->image($issue['opener']['email'])->size(56) ?>' /> 
                    <span class='top-part'>
                        Opened by <span class='name'><?= $issue['opener']['firstname'] ?> <?= $issue['opener']['lastname'] ?></span> 
                    </span>
                    <span class='bottom-part small-date'>
                        <?= $helpers->date($issue['created'])->sentence(array('elaborate_with' => 'ago')) ?> ⚫ <?= $helpers->date($issue['created'])->format('jS F, Y @ g:i a') ?>
                    </span>
                </div>                
                
                <div class='people-info'>
                    <img src='<?= $helpers->gravatar->image($issue['assignee']['email'])->size(56) ?>' /> 
                    <span class='top-part'>
                        Assigned to <span class='name'><?= $issue['assignee']['firstname'] ?> <?= $issue['assignee']['lastname'] ?></span>
                    </span>
                    <span class='bottom-part small-date'>
                        <?= $helpers->date($issue['assigned'])->sentence(array('elaborate_with' => 'ago')) ?> ⚫ <?= $helpers->date($issue['assigned'])->format('jS F, Y @ g:i a') ?>
                    </span>
                </div>
                
                <div class='people-info'>
                    <img src='<?= $helpers->gravatar->image($issue['updater']['email'])->size(56) ?>' /> 
                    <span class='top-part'>
                        Updated by <span class='name'><?= $issue['updater']['firstname'] ?> <?= $issue['updater']['lastname'] ?></span>
                    </span>
                    <span class='bottom-part small-date'>
                        <?= $helpers->date($issue['updated'])->sentence(array('elaborate_with' => 'ago')) ?> ⚫ <?= $helpers->date($issue['updated'])->format('jS F, Y @ g:i a') ?>
                    </span>
                </div>                
            </div>
        </div>
    </div>
</div>
