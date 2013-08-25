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
                <img src="<?= $helpers->gravatar->image($update['user']['email'])->size(54) ?>" />
                <span class="name"><?= $update['user']['firstname'] . " " . $update['user']['lastname'] ?></span>
                <div class="small-date"><?= $helpers->date($update['created'])->sentence(array('elaborate_with' => 'ago')) ?> ⚫ <?= $helpers->date($update['created'])->format('jS F, Y @ g:i a') ?></div>
                <?php
                $changes = array();
                if($update['assignee']['id'] != '') 
                    $changes[] = "Assigned <span class='name'>{$update['assignee']['firstname']} {$update['assignee']['lastname']}</span> to this issue";
                    
                if($update['priority'] != '')
                    $changes[] = "Set priority to <b>{$update['priority']}</b>";
                    
                if($update['kind'] != '')
                    $changes[] = "Marked issue as <b>{$update['kind']}</b>";
                ?>
                
                <?php if($update['comment'] != ''): ?>
                <p>                 
                    <?= $update['comment'] ?>
                </p>
                <?php endif; ?>
                
                <?php if(count($changes) > 0): ?>
                <ul>
                    <?php foreach($changes as $change): ?>
                    <li><?= $change ?></li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>   
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
                    
                    <?php if($issue['kind'] != ''): ?>
                    <dt>Kind</dt>
                    <dd><?= $issue['kind'] ?></dd>
                    <?php endif; ?>
                    
                    <?php if($issue['priority'] != ''): ?>
                    <dt>Priority</dt>
                    <dd><?= $issue['priority'] ?></dd>
                    <?php endif; ?>
                </dl>
                <h5>People</h5>
                
                <?php 
                echo t('people_info.tpl.php', 
                    array(
                        'action' => 'Opened by',
                        'email' => $issue['opener']['email'],
                        'firstname' => $issue['opener']['firstname'],
                        'lastname' => $issue['opener']['lastname'],
                        'time' => $issue['created']
                    )
                );
                
                if($issue['assignee']['id'] != '')
                    echo t('people_info.tpl.php', 
                        array(
                            'action' => 'Assigned to',
                            'email' => $issue['assignee']['email'],
                            'firstname' => $issue['assignee']['firstname'],
                            'lastname' => $issue['assignee']['lastname'],
                            'time' => $issue['assigned']
                        )
                    );
                      
                if($issue['updater']['id'] != '')
                    echo t('people_info.tpl.php', 
                        array(
                            'action' => 'Updated by',
                            'email' => $issue['updater']['email'],
                            'firstname' => $issue['updater']['firstname'],
                            'lastname' => $issue['updater']['lastname'],
                            'time' => $issue['updated']
                        )
                    )                         
                        
                ?>
            </div>
        </div>
    </div>
</div>
