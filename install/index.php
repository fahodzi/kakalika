<?php
error_reporting(E_ALL ^ E_NOTICE);
require "../vendor/autoload.php";
\anyen\Runner::run("wizard.php", array('banner' => 'Kakalika Installer'));

