<?php
namespace kakalika\lib;

require 'vendor/PHPMailer/PHPMailerAutoload.php';

class EmailSender
{
    private $issueNumber;
    private $message;
    private $email;        
    private $name;
    private $sourceName;
    private $subject;
    
    public function send($server)
    {
        $mail = new \PHPMailer();
        $mail->isSMTP();
        $mail->Host = $server['outgoing_server_host'];
        $mail->SMTPAuth = $server['outgoing_server_authentication'];
        $mail->Username = $server['outgoing_server_username'];
        $mail->Password = $server['outgoing_server_password'];
        $mail->SMTPSecure = $server['outgoing_server_encryption'];
        
        $mail->From = $server['email_address'];
        $mail->FromName = $this->sourceName;
        $mail->addAddress($this->email, $this->name);
        $email = explode('@', $server['email_address']);
        $mail->addReplyTo("{$email[0]}+{$this->issueNumber}@{$email[1]}", $this->name);
        $mail->Subject = "Re: {$this->subject} [#{$this->issueNumber}]";
        $mail->Body = "<span style='font-size:x-small; color:#808080'>------ Please reply above this ------</span>\n<br/><br/><p>{$this->message}</p>";
        $mail->AltBody = "------ Please reply above this ------\n\n" . $this->message;
        
        if(!$mail->send())
        {
            echo "Failed to send message. Error: {$mail->ErrorInfo}\n";
        }
        else
        {
            echo "Sent [{$mail->Subject}] to [$this->email]\n";
        }
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
}
