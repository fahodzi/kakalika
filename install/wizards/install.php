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
            $this->wizard->showMessage(
                "Some directories failed their tests. Please fix the problem and proceed.",
                "error"
            );
            $this->wizard->repeatPage();
        }
    }
    
    public function setup_prefix_render_callback()
    {
        //var_dump($_SERVER['REQUEST_URI']);
        $this->wizard->setData('prefix', 'Hello');
    }
    
    public function get_db_config_route_callback()
    {
        //@todo Allow the settings entered into anyen to be retained
        $data = $this->wizard->getData();
        @$connection = new mysqli(
            $data["host"],
            $data["username"],
            $data["password"]
        );
        
        if($connection->connect_error)
        {
            $this->wizard->showMessage(
                "Failed to connect to the database",
                "error"
            );
            $this->wizard->repeatPage();
        }
        elseif(!$connection->select_db($data['schema']))
        {
            $this->wizard->showMessage(
                "Failed to select schema {$data['schema']}",
                "error"
            );
            $this->wizard->repeatPage();            
        }
    }
}
