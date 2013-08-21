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
        'pattern' => '/^(users|projects|dashboard|admin|account|issues)/'
    ),
    array(
        "pattern" => "/(?<project>[a-zA-Z0-9_.\-]*)(\/issues\/)(?<issue_id>[0-9]*)/i",
        "route" => "issues/show/::issue_id",
        "globals" => array(
            "project" => "::project",
            "MODE" => "project",
            "PROJECT_CODE" => "::project"
        )
    ),
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
