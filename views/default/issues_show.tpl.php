<div class='issue_view'>
    <div id='title_block' class='<?= $issue['status'] ?>_title'><h4>#<?= $issue['number'] ?></h4> <h4><?= $issue['title'] ?></h4></div>
    <div class='row'>
        <div class='column grid_10_7 issue_view_content'>
            <div style='padding:15px'><?= t('issue_slug.tpl.php', array('issue' => $issue)) ?></div>
            <p id='description'><?= $this->nl2br($issue['description']) ?></p>  
            
            <?php if(count($issue['issue_attachments']->unescape()) > 0): ?>
            <ul class="main-attachment-box">
            <?php foreach($issue['issue_attachments'] as $attachment): ?>
                <li>
                    <a href='<?= u('issues/attachment/' . $attachment['id']) ?>'><?= $attachment['name'] ?></a>
                    <br/><span class="small-date"><?= $helpers->file_size($attachment['size']->unescape()) ?></span>
                </li>
            <?php endforeach; ?>
            </ul>
            <?php endif; ?>
            
            <?php if(count($issue['updates']->unescape()) > 0): ?>
            <h5>Comments (<?= count($issue['updates']->unescape()) ?>)</h5>
            <?php endif; ?>
            
            <?php $stripe = true; foreach($issue['updates'] as $update): ?>
            <div class="update <?= $stripe ? 'striped' : '' ?>">
                <div class="issue_number">#<?= $update['number'] ?></div>
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
                    
                if($update['status'] != '')
                    $changes[] = "<b>{$update['status']}</b> this issue";
                    
                if($update['milestone_id'] != '')
                    $changes[] = "Set milestone to <b>{$update['milestone']['name']}</b>";
                    
                if($update['component_id'] != '')
                    $changes[] = "Set component as <b>{$update['component']['name']}</b>";
                    
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
            
            <?= $helpers->form->open() . $helpers->form->get_text_area('Comment', 'comment') ?>
            
            <?php
                switch ($issue['status'])
                {
                    case 'OPEN':
                    case 'REOPENED':
                        echo $helpers->form->close(
                            array('value' => 'Comment', 'name' => 'action'),
                            array('value' => 'Resolve', 'name' => 'action', 'id' => 'resolve'),
                            array('value' => 'Close', 'name' => 'action', 'id' => 'close')
                        );
                        break;
                        
                    case 'CLOSED':
                        echo $helpers->form->close(
                            array('value' => 'Comment', 'name' => 'action'),
                            array('value' => 'Reopen', 'name' => 'action', 'id' => 'reopen')
                        );    
                        break;
                    
                    case 'RESOLVED':
                        echo $helpers->form->close(
                            array('value' => 'Comment', 'name' => 'action'),
                            array('value' => 'Reopen', 'name' => 'action', 'id' => 'reopen'),
                            array('value' => 'Close', 'name' => 'action', 'id' => 'close')
                        );
                        break;
                }
            ?>
        </div>
        <div class='column grid_10_3 issue_view_side'>
            <div>
                <?= $widgets->menu(
                    array(
                        array(
                            'label' => 'Edit this issue',
                            'url' => u("{$project_code}/issues/edit/{$issue['number']}"),
                            'id' => 'menu-item-issues-edit'
                        )
                    )
                )->alias('side')
                ?>
                
                <h5>Details</h5>
                <dl>
                    <dt>Status</dt>
                    <dd class="status_<?= $issue['status'] ?>"><?= $issue['status'] ?></dd>
                    
                    <?php if($issue['kind'] != ''): ?>
                    <dt>Kind</dt>
                    <dd class="kind_<?= $issue['kind'] ?>"><?= $issue['kind'] ?></dd>
                    <?php endif; ?>
                    
                    <?php if($issue['priority'] != ''): ?>
                    <dt>Priority</dt>
                    <dd class="priority_<?= $issue['priority'] ?>"><?= $issue['priority'] ?></dd>
                    <?php endif; ?>
                    
                    <?php if($issue['milestone']['id'] != ''): ?>
                    <dt>Milestone</dt>
                    <dd class="milestone"><?= $issue['milestone']['name'] ?><span class='small-date'> ⚫ Due <?= $helpers->date($issue['milestone']['due_date'])->sentence(array('elaborate_with' => 'ago')) ?></span></dd>
                    <?php endif; ?>
                    
                    <?php if($issue['component']['id'] != ''): ?>
                    <dt>Component</dt>
                    <dd class="component"><?= $issue['component']['name'] ?></dd>
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

