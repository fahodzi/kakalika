<?php
namespace kakalika\lib;

use ntentan\honam\TemplateEngine;

class EmailSender
{
    private $issueNumber;
    private $message;
    private $email;        
    private $name;
    private $sourceName;
    private $subject;
    private $changes;
    private $attachments = array();
    
    public function send($server)
    {
        $mail = new \PHPMailer();
        $mail->isSMTP();
        $mail->Host = $server['outgoing_server_host'];
        $mail->SMTPAuth = $server['outgoing_server_authentication'];
        $mail->Username = $server['outgoing_server_username'];
        $mail->Password = $server['outgoing_server_password'];
        $mail->SMTPSecure = $server['outgoing_server_encryption'];
        $mail->SMTPOptions = array (
            'ssl' => array(
                'verify_peer'  => false,
                'allow_self_signed' => true,
            )
        );
        
        $mail->From = $server['email_address'];
        $mail->FromName = $this->sourceName;
        $mail->addAddress($this->email, $this->name);
        $email = explode('@', $server['email_address']);
        $mail->addReplyTo("{$email[0]}+{$this->issueNumber}@{$email[1]}", $server["email_display_name"]);
        $mail->Subject = "Re: {$this->subject} [#{$this->issueNumber}]";
        
        if($this->changes['assignee'] != '')
        {
            $this->changes['assignee'] = \kakalika\modules\users\Users::getJustFirstWithId($this->changes['assignee'])->toArray();
        }
        if($this->changes['milestone_id'] != '')       
        {
            $this->changes['milestone'] = \kakalika\modules\milestones\Milestones::getJustFirstWithId($this->changes['milestone_id'])->toArray();
        }
        if($this->changes['component_id'] != '')       
        {
            $this->changes['component'] = \kakalika\modules\components\Components::getJustFirstWithId($this->changes['component_id'])->toArray();
        }
        
        $data = array(
            'message' => $this->message,
            'changes' => $this->changes
        );
        
        $mail->Body = TemplateEngine::render("html_update.tpl.php", $data);
        $mail->AltBody = TemplateEngine::render("txt_update.tpl.php", $data);
        
        foreach($this->attachments as $attachment)
        {
            $mail->addAttachment($attachment['path'], $attachment['filename']);
        }
        
        if(!$mail->send())
        {
            echo "Failed to send message. Error: {$mail->ErrorInfo}\n";
        }
        else
        {
            echo "Sent [{$mail->Subject}] to [$this->email]\n";
        }
    }
    
    public function setChanges($changes)
    {
        $this->changes = $changes;
    }
    
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }
    
    public function setIssueNumber($issueNumber)
    {
        $this->issueNumber = $issueNumber;
    }
    
    public function setMessage($message)
    {
        $this->message = $message;
    }
    
    public function setDestination($email, $name)
    {
        $this->email = $email;
        $this->name = $name;
    }
    
    public function setSource($name)
    {
        $this->sourceName = $name;
    }
    
    public function addAttachment($path, $filename)
    {
        $this->attachments[] = array(
            'path' => "uploads/$path",
            'filename' => $filename
        );
    }
}
