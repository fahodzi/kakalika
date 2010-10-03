<?php
/**
 * 
 */

include "../ntentan/Ntentan.php";

use ntentan\Ntentan;

Ntentan::$basePath = "../ntentan/";
Ntentan::$modulesPath = "kakalika";
Ntentan::$defaultRoute = "feed";

Ntentan::addIncludePath("lib");

Ntentan::$routes = array(
    array(
        "pattern" => "/(admin)(\/)?(?<path>[a-zA-Z1-3\/_]*)?/i",
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
        "pattern" => "/(?<project>[a-zA-Z1-3_.\-]+){1}(\/)?(?<path>[a-zA-Z1-3\/_]*)?/i",
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
