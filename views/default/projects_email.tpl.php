<h4>Email integration settings for <?= $project['name'] ?></h4>
<div class="row">
    <div class="column grid_10_7">
        <?php
        $helpers->form->setData($settings);
        //var_dump($settings);
        ?>
        <?= $helpers->form->open() ?>
        <div>
            <?= $helpers->form->get_checkbox('Enable email integration for this project', 'email_integration') ?>
            <?= $helpers->form->get_text_field('Display Name for Email', 'email_display_name')->addCssClass('normal-size') ?>
            <?= $helpers->form->get_text_field('Email Address', 'email_address')->addCssClass('normal-size') ?>
        </div>
        <div class="row" style="width: 100%">
            <div class="column grid_10_5">
                <?= 
                $helpers->form->open_field_set('Incoming email settings') . 
                $helpers->form->get_text_field('Incoming server host', 'incoming_server_host') . 
                $helpers->form->get_selection_list('Incoming server type', 'incoming_server_type')
                    ->addOption('IMAP', 'imap')
                    ->addOption('POP3', 'pop3').
                $helpers->form->get_text_field('Incoming server port', 'incoming_server_port') . 
                $helpers->form->get_checkbox('Use encryption SSL', 'incoming_server_ssl').
                $helpers->form->get_text_field('Username', 'incoming_server_username').                
                $helpers->form->get_password_field('Password', 'incoming_server_password').
                $helpers->form->close_field_set(); 
                ?>
            </div>
            <div class="column grid_10_5">
                <?=
                $helpers->form->open_field_set('Outgoing email settings') . 
                $helpers->form->get_text_field('Outgoing server host', 'outgoing_server_host') . 
                $helpers->form->get_text_field('Outgoing server port', 'outgoing_server_port') . 
                $helpers->form->get_selection_list('Use encryption', 'outgoing_server_encryption')
                    ->addOption('SSL', 'ssl')
                    ->addOption('TLS', 'tls').
                $helpers->form->get_checkbox('Requires authentication', 'outgoing_server_authentication').
                $helpers->form->get_text_field('Username', 'outgoing_server_username').                
                $helpers->form->get_password_field('Password', 'outgoing_server_password').
                $helpers->form->close_field_set();  
                ?>
            </div>
        </div>
        <?= $helpers->form->close('Save') ?>
    </div>
    <div class="column grid_10_3">
        <?= t('project_side_menu.tpl.php', array('id' => $id))?>
    </div>
</div>