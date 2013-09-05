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
        
        foreach($response as $res)
        {
            $this->wizard->setData('f', 1);
        }
        
        return $response;        
    }
    
    public function checking_directories_route_callback()
    {
        //$data = $th
    }
}
