<div class='issue_view'>
    <div id='title_block'><h4>#<?= $issue['number'] ?></h4> <h4><?= $issue['title'] ?></h4></div>
    <div class='row'>
        <div class='column grid_10_7'>
            <div style='padding:15px'><?= t('issue_slug.tpl.php', array('issue' => $issue)) ?></div>
            <p id='description'><?= $this->nl2br($issue['description']) ?></p>     
            <?= 
                $helpers->form->open() .
                $helpers->form->get_text_area('Comment', 'comment') .
                $helpers->form->close('Update Issue') 
            ?>
        </div>
        <div class='column grid_10_3'>
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
                        <?= $helpers->date($issue['created'])->sentence(array('elaborate_with' => 'ago')) ?>.
                    </span>
                    <span class='bottom-part'>
                        <?= $helpers->date($issue['created'])->format('jS F, Y @ g:i a') ?>
                    </span>
                </div>                
                
                <div class='people-info'>
                    <img src='<?= $helpers->gravatar->image($issue['assignee']['email'])->size(56) ?>' /> 
                    <span class='top-part'>
                        Assigned to <span class='name'><?= $issue['assignee']['firstname'] ?> <?= $issue['assignee']['lastname'] ?></span> 
                        <?= $helpers->date($issue['assigned'])->sentence(array('elaborate_with' => 'ago')) ?>.
                    </span>
                    <span class='bottom-part'>
                        <?= $helpers->date($issue['assigned'])->format('jS F, Y @ g:i a') ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
