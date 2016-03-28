<?php
/**
 * Kakalika's entry point
 * 
 * Ntentan Framework
 * Copyright (c) 2013 James Ekow Abaka Ainooson
 * 
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 * 
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE. 
 * 
 * @author James Ainooson <jainooson@gmail.com>
 * @copyright Copyright 2013 James Ekow Abaka Ainooson
 * @license MIT
 */

require "vendor/autoload.php";

use ntentan\Router;
use ntentan\Ntentan;
use kakalika\modules\projects\Projects;


Router::mapRoute(
    'default', '{controller}/{action}/{*params}', 
    ['default' => ['controller' => 'Projects', 'action' => 'index']]
);

Router::mapRoute(
    'login', 'login', 
    ['default' => ['controller' => 'Dashboard', 'action' => 'login']]
);

Router::mapRoute(
    'logout', 'logout', 
    ['default' => ['controller' => 'Dashboard', 'action' => 'logout']]
);

Router::mapRoute(
    'admin', 'admin/{*route}', ['default' => ['mode' => 'admin', 'route' => '']]
);

Router::mapRoute(
    'project', '{project}/{action}/{*params}',
    ['default' => ['controller' => 'Issues', 'action' => 'page', 'mode' => 'project']]
);


try{    
    Ntentan::start('kakalika');
}
catch(ntentan\exceptions\ApiIniFileNotFoundException $e)
{
    $url = ntentan\utils\Input::server('REQUEST_URI');
    header("Location: {$url}install");
}
