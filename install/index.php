<?php
error_reporting(E_ALL ^ E_NOTICE);

require "anyen/src/Anyen.php";
require "anyen/src/AnyenWeb.php";

Anyen::run("wizards/install.yml", array('banner' => 'Kakalika Installer'));

