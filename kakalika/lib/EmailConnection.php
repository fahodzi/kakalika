<?php
namespace kakalika\lib;

class EmailConnection
{
    private $connection;
    private $params;
    private $messages;
    private $numberOfMessages = 0;
    private $messageKeys = array();
    private $currentMessage = 0;
    
    public function __construct($params = array())
    {
        $this->params = $params;
    }
    
    public function setHost($host)
    {
        $this->params['host'] = $host;
    }
    
    public function setPort($port)
    {
        $this->params['port'] = $port;
    }
    
    public function setType($type)
    {
        $this->params['type'] = $type;
    }
    
    public function setSsl($ssl)
    {
        $this->params['ssl'] = $ssl;
    }
    
    public function setUsername($username)
    {
        $this->params['username'] = $username;
    }
    
    public function setPassword($password)
    {
        $this->params['password'] = $password;
    }
    
    public function open()
    {
        if($this->params['ssl']) $ssl = "/ssl/novalidate-cert";
        $this->connection = imap_open(
            "{{$this->params['host']}:{$this->params['port']}/{$this->params['type']}$ssl}INBOX",
            $this->params['username'], $this->params['password']
        );   
        if($this->connection === false)
        {
            throw new Exception('Failed to open IMAP connection');
        }
        $this->messages = imap_search($this->connection, 'UNSEEN');
        if($this->messages)
        {
            $this->messageKeys = array_keys($this->messages);
            $this->numberOfMessages = count($this->messages);
        }
    }
    
    public function getNumberOfMessages()
    {
        return count($this->messages);
    }
    
    public function getNextMessage()
    {
        return new EmailMessage($this->connection, $this->messages[$this->messageKeys[$this->currentMessage++]]);
    }
    
    public function hasMessage()
    {
        return $this->currentMessage < $this->numberOfMessages;
    }
}
