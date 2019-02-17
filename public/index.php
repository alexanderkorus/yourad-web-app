<?php

/**
 * Front controller
 *
 */


//echo 'Requested URL = "' . $_SERVER['QUERY_STRING'] . '"';


require '../Core/Router.php';

$router = new Router();

$router->add('', ['controller' => 'Home', 'action' => 'index']);

