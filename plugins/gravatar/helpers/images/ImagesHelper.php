<?php
namespace ntentan\plugins\gravatar\helpers\images;

use \ntentan\views\helpers\Helper;

class ImagesHelper extends Helper
{
    private $hash;
    private $size = 48;
    
    public function help($email)
    {
        $this->hash = md5(strtolower(trim($email)));
        return $this;
    }
    
    public function size($size)
    {
        $this->size = $size;
        return $this;
    }
    
    public function __toString() 
    {
        return "http://www.gravatar.com/avatar/{$this->hash}.jpg?s={$this->size}&amp;d=mm";
    }
}