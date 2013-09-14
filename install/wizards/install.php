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
        $this->wizard->setData('prefix', str_replace('/', '', $matches['prefix']));
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
        
        print "Done setting up database";
    }
    
    public function setup_admin_route_callback()
    {
        $data = $this->wizard->getData();

        @$connection = new mysqli(
            $data["host"],
            $data["username"],
            $data["password"]
        );

        $connection->select_db($data['schema']);        
        
        $connection->query(
            sprintf(
                "INSERT INTO 
                    users(username, password, firstname, lastname, email, is_admin)
                 VALUES ('%s', '%s', '%s', '%s', '%s', true)",
                $connection->escape_string($data['admin_username']),
                $connection->escape_string(md5($data['admin_password'])),
                $connection->escape_string($data['firstname']),
                $connection->escape_string($data['lastname']),
                $connection->escape_string($data['email'])
            )
        );
        
$appFile = <<< APPFILE
context = deployed
prefix = {$data['prefix']}

[deployed]
caching = file
error_reporting = error

APPFILE;

        file_put_contents("../config/app.ini", $appFile);        
        
$dbFile = <<< DBFILE
[deployed]
datastore = mysql
host = {$data['host']}
user = {$data['username']}
password = {$data['password']}
name = {$data['schema']}

DBFILE;
        
        file_put_contents("../config/db.ini", $dbFile);
        
    }
}


