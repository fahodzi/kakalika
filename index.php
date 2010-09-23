<?php
include "../ntentan/Ntentan.php";

use ntentan\Ntentan;

Ntentan::$basePath = "../ntentan/";
Ntentan::$modulesPath = "kakalika";
Ntentan::$defaultRoute = "feed";
Ntentan::boot();
