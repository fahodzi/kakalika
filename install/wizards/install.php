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
        preg_match("/(?<prefix>.*)(\/install)/i", $_SERVER['REQUEST_URI'], $matches);
        $this->wizard->setData('prefix', $matches['prefix']);
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
    
    public function setup_database()
    {
        $data = $this->wizard->getData();
        @$connection = new mysqli(
            $data["host"],
            $data["username"],
            $data["password"]
        );

        $connection->select_db($data['schema']);
        $queries = file_get_contents('mysql_schema.sql');
        $queries = explode(';', $queries);
                
        foreach($queries as $query)
        {
            $connection->query($query);
        }
    }
}
