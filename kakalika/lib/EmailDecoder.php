<?php

namespace kakalika\lib;

/**
 * A simple class to decode the IMAP messages.
 * 
 * Adapted from user contributed note on imap_fetchstructure help page by
 * david at hundsness dot com.
 */
class EmailDecoder
{
    private $imap;
    private $message;
    private $plainTextMessage = false;
    private $htmlMessage = false;
    private $attachments = array();
    private $characterSet = false;
    private $overview;
    private $headers;
    
    
    public function __construct($imap, $message)
    {
        $this->imap = $imap;
        $this->message = $message;
        $this->headers = imap_header($imap, $message);
        $this->overview = imap_fetch_overview($imap, $message);
        $structure = imap_fetchstructure($imap, $message);
        
        if(!$structure->parts)
        {
            $this->plainTextMessage = imap_body($imap, $message);
        }
        else
        {
            foreach($structure->parts as $partNumber => $part)
            {
                $this->decode($partNumber + 1, $part);
            }
        }
    }
    
    private function stripQuotedMessages($message)
    {
        // Remove everything after the please reply above this
        $lines = explode("\n", $message);
        $output = array();
        foreach($lines as $line)
        {
            if(preg_match("/Reply above this line to comment on this issue/i", $line)) break;
            $output[] = $line;
        }
        
        $lines = $output;
        
        // Remove any extra lines added by the mail cient
        for($i = count($lines) - 1; $i >= 0; $i--)
        {
            if(trim($lines[$i]) == '') 
            {
                unset($output[$i]);
                continue;
            }
            else
            {
                if(preg_match("/(on)(.*)(wrote)/i", $lines[$i])) unset($output[$i]);
                if(preg_match("/(original message)/i", $lines[$i])) unset($output[$i]);
                break;
            }
        }
        
        return implode("\n", $output);
    }
    
    private function decode($partNumber, $part)
    {
        $data = imap_fetchbody($this->imap, $this->message, $partNumber);
        switch($part->encoding)
        {
            case 4:
                $data = quoted_printable_decode($data);
                break;
            case 3:
                $data = base64_decode($data);
                break;
        }
        
        $params = array();
        
        if($part->parameters)
        {
            foreach($part->parameters as $parameter)
            {
                $params[strtolower($parameter->attribute)] = $parameter->value;
            }
        }
        if($part->dparameters)
        {
            foreach($part->dparameters as $parameter)
            {
                $params[strtolower($parameter->attribute)] = $parameter->value;
            }
        }
        
        // Extract text
        if ($part->type == 0 && $data) 
        {
            if (strtolower($part->subtype)=='plain')
            {
                $this->plainTextMessage .= $this->stripQuotedMessages(trim($data));
            }
            else
            {    
                $this->htmlMessage .= $data;
            }
            $this->characterSet = $params['charset'];  // assume all parts are same charset
        }  
        
        // process sub parts
        if ($part->parts) {
            foreach ($part->parts as $subPartNumber => $subPart)
            {
                $this->decode($partNumber . '.' . ($subPartNumber + 1));
            }
        }
    }
    
    public function getPlainText()
    {
        return $this->plainTextMessage;
    }
    
    public function getHtml()
    {
        return $this->htmlMessage;
    }
    
    public function getMessage()
    {
        if($this->htmlMessage !== false)
        {
            return $this->htmlMessage;
        }
        else
        {
            return $this->plainTextMessage;
        }
    }
    
    public function getSubject()
    {
        return $this->overview[0]->subject;
    }
    
    public function getToAddress()
    {
        return "{$this->headers->to[0]->mailbox}@{$this->headers->to[0]->host}";
    }
    
    public function getFromAddress()
    {
        return "{$this->headers->from[0]->mailbox}@{$this->headers->from[0]->host}";
    }
    
    public function getSenderName()
    {
        return $this->headers->from[0]->personal;
    }
    
    public function getTimestamp()
    {
        return date('Y-m-d H:i:s', $this->headers->udate);
    }
}

