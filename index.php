<?php
require ('config/config.php');
require "{$config['application']['ntentan_home']}/lib/Ntentan.php";
use ntentan\Ntentan;

Ntentan::$defaultRoute = 'projects';

Ntentan::setup($config);
Ntentan::$routes = array(
    array(
        'pattern' => '/login/',
        'route' => 'projects/login'
    ),
    array(
        'pattern' => '/logout/',
        'route' => 'projects/logout'
    ),
    array(
        'pattern' => '/(users|projects|dashboard)/'
    ),
    array(
        "pattern" => "/(?<project>[a-zA-Z1-3_.\-]*)(\/)?(?<path>[a-zA-Z1-3\/_]*)?/i",
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
