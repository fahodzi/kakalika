<?php
namespace kakalika\users;

use \ntentan\models\Model;

class Users extends Model
{
    public function resetPassword()
    {
        $this->password = "";
        if($this->update()==false) 
        {
            
        }
    }
    
    public function preSaveCallback()
    {
        $this["password"] = md5($this["password"]);
    }
    
    public function __toString()
    {
        return $this->data["full_name"];// . ($this->data["email"] == "" ? "" : " &lt;{$this->data["email"]}&gt;") ;
    }
}
