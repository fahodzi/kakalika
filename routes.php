<?php

/**
 * Kakalika's routing logic
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


// Make projects the default route
ntentan\Ntentan::$defaultRoute = 'projects';

// Define the route renaming scheme
ntentan\Ntentan::$routes = array(
    // Route the login pages
    array(
        'pattern' => '/login/',
        'route' => 'dashboard/login'
    ),
    
    // Route the logout pages
    array(
        'pattern' => '/logout/',
        'route' => 'dashboard/logout'
    ),
    
    // Route to the users editor
    array(
        'pattern' => "/account/",
        'route' => 'users/edit'
    ),    

    // Admin
    array(
        "pattern" => "/^(admin)(\/)?(?<path>[a-zA-Z0-9\/_]*)?/",
        "route" => "::path",
        "default" => "projects",
        "globals" => array(
            "MODE" => "admin"
        )
    ),
    
    // Exclude the routing for certain pages
    array(
        'pattern' => '/^(users|projects|dashboard|admin|account|issues|error)/'
    ),
    
    // Route to the project editor
    array(
        "pattern" => "/^(?<project>[a-zA-Z0-9_\-]+)(\/edit)/i",
        "route" => "projects/edit/::project"
    ),
    
    // Route to issue views
    array(
        "pattern" => "/^(?<project>[a-zA-Z0-9_.\-]+)(\/issues\/)(?<issue_id>[0-9]+)/i",
        "route" => "issues/show/::issue_id",
        "globals" => array(
            "project" => "::project",
            "MODE" => "project",
            "PROJECT_CODE" => "::project"
        )
    ),
    
    // Route to project pages
    array(
        "pattern" => "/(?<project>[a-zA-Z0-9_.\-]*)(\/)?(?<path>[a-zA-Z0-9\/_]*)?/i",
        "route" => "::path",
        "default" => "issues",
        "globals" => array(
            "project" => "::project",
            "MODE" => "project",
            "PROJECT_CODE" => "::project"
        )
    )
);

