<?php
require ('config/config.php');
require "{$config['application']['ntentan_home']}/lib/Ntentan.php";
use ntentan\Ntentan;

xdebug_start_trace();

Ntentan::boot($config);
