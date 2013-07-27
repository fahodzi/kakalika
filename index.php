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
    )
);
Ntentan::route();
