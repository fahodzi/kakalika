<?php

require ('config/config.php');
require "{$config['application']['ntentan_home']}/lib/Ntentan.php";

use ntentan\Ntentan;

Ntentan::$defaultRoute = 'projects';

Ntentan::setup($config);
Ntentan::$routes = array(
    // Route the login pages
    array(
        'pattern' => '/login/',
        'route' => 'projects/login'
    ),
    
    // Route the logout pages
    array(
        'pattern' => '/logout/',
        'route' => 'projects/logout'
    ),
    
    // Route to the users editor
    array(
        'pattern' => "/account/",
        'route' => 'users/edit'
    ),    

    // Admin
    array(
        "pattern" => "/^(admin)(\/)?(?<path>[a-zA-Z0-9\/_]*)?/",
        "route" => "::path",
        "default" => "users",
        "globals" => array(
            "MODE" => "admin"
        )
    ),
    
    
    // Exclude the routing for certain pages
    array(
        'pattern' => '/^(users|projects|dashboard|admin|account|issues)/'
    ),
    
    // Route to the project editor
    array(
        "pattern" => "/^(?<project>[a-zA-Z0-9_\-]+)(\/edit)/i",
        "route" => "projects/edit/::project"
    ),
    
    // Route to issue views
    array(
        "pattern" => "/^(?<project>[a-zA-Z0-9_.\-]+)(\/issues\/)(?<issue_id>[0-9]+)/i",
        "route" => "issues/show/::issue_id",
        "globals" => array(
            "project" => "::project",
            "MODE" => "project",
            "PROJECT_CODE" => "::project"
        )
    ),
    
    // Route to project pages
    array(
        "pattern" => "/(?<project>[a-zA-Z0-9_.\-]*)(\/)?(?<path>[a-zA-Z0-9\/_]*)?/i",
        "route" => "::path",
        "default" => "issues",
        "globals" => array(
            "project" => "::project",
            "MODE" => "project",
            "PROJECT_CODE" => "::project"
        )
    )
);

Ntentan::route();
