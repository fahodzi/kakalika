<?php
require ('config/config.php');
require "{$config['application']['ntentan_home']}/lib/Ntentan.php";
use ntentan\Ntentan;

Ntentan::boot($config);
