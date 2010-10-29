<?php
/**
 * 
 */
include "config/ntentan.php";
include $ntentan_home . "Ntentan.php";

use ntentan\Ntentan;

Ntentan::$defaultRoute = "dashboard";

Ntentan::addIncludePath("lib");

Ntentan::$routes = array(
    array(
        "pattern" => "/(admin)(\/)?(?<path>[a-zA-Z0-9\/_]*)?/i",
        "route" => "::path",
        "globals" => array(
            "MODE" => "ADMIN"
        )
    ),
    array(
        "pattern" => "/(users)(\/)?.*/i"
    ),
    array(
        "pattern" => "/(inbox)(\/)?.*/i"
    ),
    array(
        "pattern" => "/(dashboard)(\/)?.*/i",
        "globals" => array(
            "MODE" => "DASHBOARD"
        )
    ),
    array(
        "pattern" => "/(?<project>[a-zA-Z1-3_.\-]+){1}(\/)?(?<path>[a-zA-Z0-9\/_]*)?/i",
        "route" => "::path",
        "globals" => array(
            "MODE" => "PROJECT",
            "PROJECT_NAME" => "::project"
        )
    ),
    array(
        "pattern" => "//",
        "globals" => array(
            "MODE" => "DASHBOARD"
        )
    ),    
);

Ntentan::boot();
