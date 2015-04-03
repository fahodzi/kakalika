<?php
class install extends anyen\wizard_logic
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
        $data = $this->wizard->getData();
        try{
            $driver =ntentan\atiaa\Driver::getConnection(
                array(
                    'driver' => 'mysql',
                    'user' => $data['username'],
                    'password' => $data['password'],
                    'host' => $data['host'],
                    'dbname' => $data['schema']
                )
            );
            
$appFile = <<< APPFILE
context = deployed
prefix = {$data['prefix']}

[deployed]
caching = file
error_reporting = error

APPFILE;

            file_put_contents(__DIR__ . "/../../config/app.ini", $appFile);        
        
$dbFile = <<< DBFILE
[deployed]
datastore = mysql
host = {$data['host']}
user = {$data['username']}
password = {$data['password']}
name = {$data['schema']}

DBFILE;
        
            file_put_contents(__DIR__ . "/../../config/db.ini", $dbFile);            
            $driver->disconnect();
            
        }
        catch(PDOException $e)
        {
            $this->wizard->showMessage(
                "Failed to connect to the database. Database driver says \"{$e->getMessage()}\"",
                "error"
            );
            $this->wizard->repeatPage();            
        }
    }
    
    public function setup_database()
    {
        chdir("..");
        $command = new yentu\commands\Migrate();
        $command->run();
        chdir("install");
        
        print "Done setting up database";
    }
    
    public function setup_admin_route_callback()
    {
        $data = $this->wizard->getData();
        chdir("..");
        $ntentan = parse_ini_file('config/ntentan.ini', true);
        ntentan\Ntentan::setup($ntentan);
        
        $user = kakalika\modules\users\Users::getNew();
        $user->username = $data['admin_username'];
        $user->password = md5($data['admin_password']);
        $user->firstname = $data['firstname'];
        $user->lastname = $data['lastname'];
        $user->email = $data['email'];
        $user->is_admin = true;
        
        $user->save();
    }
}


