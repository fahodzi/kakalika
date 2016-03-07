<?php
use anyen\Wizard;

return [
    wizard::page(
        "Welcome to Kakalika's Installer",
        wizard::text(
            "Welcome to the kakalika bug tracker's installer. This wizard would help you ". 
            "setup the kakalika bug tracker on your server. Kakalika is a simple ".
            "lightweight issue tracker. We hope you enjoy using it."
        )
    ),
    wizard::page(
        "Checking directories",
        wizard::checklist(
            function($wizard)
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
                    $response["$directory directory exists"] = file_exists(__DIR__ . "/../$directory");
                    $response["$directory directory is writeable"] = is_writable(__DIR__ . "/../$directory");
                }

                $success = 1;
                foreach($response as $res)
                {
                    $success &= $res;
                }
                $wizard->setData('success', $success);

                return $response;                   
            }
        ),
        wizard::onroute(function($wizard){
            if(!$wizard->getData('success'))
            {
                $wizard->showMessage(
                    "Some directories failed their tests. Please fix the problem and proceed.",
                    "error"
                );
                $wizard->repeatPage();
            }            
        })
    ),
    wizard::page(
        "Web access prefix",
        wizard::text(
            "The prefix is usually the name of the directory in which kakalika
            resides within your document root."
        ),
        wizard::input('Prefix', 'prefix'),
        wizard::onrender(function($wizard)
        {
            preg_match("/(?<prefix>.*)(\/install)/i", filter_input(INPUT_SERVER, 'REQUEST_URI'), $matches);
            $wizard->setData('prefix', str_replace('/', '', $matches['prefix']));            
        })
    ),
    wizard::page(
        "Database Configuration",
        wizard::text("Please provide the details for the database configuration."),
        wizard::input(
            "What database are we connecting to", "driver", 
            [
                'required' => true, 
                'options' => ['postgresql', 'mysql', 'sqlite']
            ]
        ),
        wizard::input(
            "What's the host of the database connection", 'host'
        ),
        wizard::input(
            "What username should we connect with", 'username'
        ),
        wizard::input(
            "What's your password", 'password', ['masked' => true]
        ),
        wizard::input(
            "What database should we use (must already exist)", 'schema'
        ),
        wizard::input(
            "What file do you want to store your database in (sqlite only)", "filename"
        ),
        wizard::onroute(function($wizard){
            $data = $wizard->getData();
            chdir(__DIR__ . "/..");
            try{
                $driver = \ntentan\atiaa\Driver::getConnection(
                    array(
                        'driver' => $data['driver'],
                        'user' => $data['username'],
                        'password' => $data['password'],
                        'host' => $data['host'],
                        'dbname' => $data['schema'],
                        'file' => $data['filename']
                    )
                );
            
                $appFile = "context = deployed\n" .
                    "prefix = {$data['prefix']}\n\n" .
                    "[deployed]\n" .
                    "caching = file\n" .
                    "error_handler = error\n";

                file_put_contents("config/app.ini", $appFile);        
        
                $dbFile = "[deployed]\n" .
                    "datastore = {$data['driver']}\n".
                    "host = {$data['host']}\n".
                    "user = {$data['username']}\n".
                    "password = {$data['password']}\n".
                    "name = {$data['schema']}\n".
                    "file = {$data['filename']}";

                file_put_contents("config/db.ini", $dbFile);            
                $driver->disconnect();

            }
            catch(\ntentan\atiaa\DatabaseDriverException $e)
            {
                $wizard->showMessage(
                    "Failed to connect to the database. Database driver says \"{$e->getMessage()}\"",
                    "error"
                );
                $wizard->repeatPage();            
            }
        })
    ),
    wizard::page(
        "Setting up Database",
        wizard::call(function($wizard)
        {
            chdir(__DIR__ . "/..");
            try{
                $command = new \yentu\commands\Migrate();
                $command->run();
                print "Done setting up database";
            }
            catch(\Exception $e)
            {
                $wizard->showMessage(
                    "Error creating database: {$e->getMessage()}", 'error'
                );
                $wizard->repeatPage();
            }
        })
    ),
    wizard::page(
        "Create Administrative User",
        wizard::text(
            "Create the first administrative user of the system. You can use this
            user account to login after the installer has finished running."
        ),
        wizard::input("Firstname", 'firstname', ['required' => true]),
        wizard::input("Lastname", 'lastname'),
        wizard::input('Email', 'email'),
        wizard::input('Username', 'admin_username'),
        wizard::input('Password', 'admin_password', ['masked' => true]),
            
        wizard::onroute(function($wizard){
            $data = $wizard->getData();
            chdir(__DIR__ . "/../..");
            $ntentan = parse_ini_file('config/ntentan.ini', true);
            \ntentan\Ntentan::setup($ntentan);

            $user = \kakalika\modules\users\Users::getNew();
            $user->username = $data['admin_username'];
            $user->password = md5($data['admin_password']);
            $user->firstname = $data['firstname'];
            $user->lastname = $data['lastname'];
            $user->email = $data['email'];
            $user->is_admin = true;

            $user->save();            
        })
    ),
    wizard::page(
        'Thanks!',
        wizard::text(
            "Thanks for installing kakalika. For security reasons please delete the
            install directory once you are done installing the application. 
            Hope you enjoy this. Happy issue tracking!"
        )
    )
];