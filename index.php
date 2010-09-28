<?php
include "../ntentan/Ntentan.php";

use ntentan\Ntentan;

Ntentan::$basePath = "../ntentan/";
Ntentan::$modulesPath = "kakalika";
Ntentan::$defaultRoute = "feed";

Ntentan::$routes = array(
    array(
        "pattern" => "/(admin)(\/)?(?<path>[a-zA-Z1-3\/_]*)?/i",
        "route" => "::path",
        "globals" => array(
            "admin" => true
        )
    ),
    array(
        "pattern" => "/(?<project>[a-zA-Z1-3_.\-]*)(\/)?(?<path>[a-zA-Z1-3\/_]*)?/i",
        "route" => "::path",
        "globals" => array(
            "project" => "::project"
        )
    )
);

Ntentan::boot();
