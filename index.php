<?php
error_reporting(E_ALL  ^ E_NOTICE);
$ntentan = parse_ini_file('config/ntentan.ini', true);
require "{$ntentan['home']}/lib/Ntentan.php";

use ntentan\Ntentan;

Ntentan::setup($ntentan);
include('routes.php');
Ntentan::route();
