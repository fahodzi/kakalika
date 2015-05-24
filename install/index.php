<?php
error_reporting(E_ALL ^ E_NOTICE);
require "../vendor/autoload.php";
\anyen\Runner::run("wizards/install.php", array('banner' => 'Kakalika Installer'));

