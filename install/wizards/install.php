<?php
class install extends wizard_logic
{
    public function check_directories()
    {
        $directories = array(
            'cache',
            'public/js',
            'public/css',
            'public/images',
            'config',
            'logs',
        );
        
        $response = array();
        foreach($directories as $directory)
        {
            $response["$directory directory exists"] = file_exists(__DIR__ . "/../../$directory");
            $response["$directory directory is writeable"] = is_writable(__DIR__ . "/../../$directory");
        }
        
        $success = 1;
        foreach($response as $res)
        {
            $success &= $res;
        }
        $this->wizard->setData('success', $success);
        
        return $response;        
    }
    
    public function checking_directories_route_callback()
    {
        if(!$this->wizard->getData('success'))
        {
            $this->wizard->repeatPage();
        }
    }
}
