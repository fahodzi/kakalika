<?php
namespace anyen\wizard;

$wizard = [
    page(
        "Welcome to Kakalika's Installer",
        text(
            "Welcome to the kakalika bug tracker's installer. This wizard would help you ". 
            "setup the kakalika bug tracker on your server. Kakalika is a simple ".
            "lightweight issue tracker. We hope you enjoy using it."
        )
    ),
    page(
        "Checking directories",
        checklist(
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
                    $response["$directory directory exists"] = file_exists(__DIR__ . "/../../$directory");
                    $response["$directory directory is writeable"] = is_writable(__DIR__ . "/../../$directory");
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
        onroute(function($wizard){
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
    page(
        "Web access prefix",
        text(
            "The prefix is usually the name of the directory in which kakalika
            resides on your document root. What web prefix would you like to access 
            your application through?"
        ),
        input('Prefix', 'prefix'),
        onrender(function($wizard)
        {
            preg_match("/(?<prefix>.*)(\/install)/i", filter_input(INPUT_SERVER, 'REQUEST_URI'), $matches);
            $wizard->setData('prefix', str_replace('/', '', $matches['prefix']));            
        })
    ),
    page(
        "Database Configuration",
        text("Please provide the details for the database configuration."),
        input(
            "What database are we connecting to", "driver", 
            [
                'required' => true, 
                'options' => ['postgresql', 'mysql']
            ]
        ),
        input("What's the host of the database connection", 'host', ['required' => true]),
        input("What username should we connect with", 'username', ['required' => true]),
        input("What's your password", 'password'),
        input("What database schema should we use (must already exist)", 'schema', ['required' => true]),
        onroute(function($wizard){
            $data = $wizard->getData();
            try{
                $driver = \ntentan\atiaa\Driver::getConnection(
                    array(
                        'driver' => $data['driver'],
                        'user' => $data['username'],
                        'password' => $data['password'],
                        'host' => $data['host'],
                        'dbname' => $data['schema']
                    )
                );
            
                $appFile = "context = deployed\n" .
                    "prefix = {$data['prefix']}\n\n" .
                    "[deployed]\n" .
                    "caching = file\n" .
                    "error_handler = error\n";

                file_put_contents(__DIR__ . "/../../config/app.ini", $appFile);        
        
                $dbFile = "[deployed]\n" .
                    "datastore = {$data['driver']}\n".
                    "host = {$data['host']}\n".
                    "user = {$data['username']}\n".
                    "password = {$data['password']}\n".
                    "name = {$data['schema']}\n";

                file_put_contents(__DIR__ . "/../../config/db.ini", $dbFile);            
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
    page(
        "Setting up Database",
        call(function()
        {
            chdir("..");
            $command = new \yentu\commands\Migrate();
            $command->run();
            chdir("install");
            print "Done setting up database";
        })
    ),
    page(
        "Create Administrative User",
        text(
            "Create the first administrative user of the system. You can use this
            user account to login after the installer has finished running."
        ),
        input("Firstname", 'firstname', ['required' => true]),
        input("Lastname", 'lastname'),
        input('Email', 'email'),
        input('Username', 'admin_username'),
        input('Password', 'admin_password'),
            
        onroute(function($wizard){
            $data = $wizard->getData();
            chdir("..");
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
    page(
        'Thanks!',
        text(
            "Thanks for trying out kakalika. For security reasons please delete the
            install directory once you are done installing the application. 
            Hope'n you enjoy this. Happy issue tracking!"
        )
    )
];