<?php

/**
 * Front controller
 * User: Alexander Korus
 * Date: 2019-02-17
 */


require '../vendor/autoload.php';

Twig_Autoloader::register();


error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

$router = new Core\Router();

$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('signin', ['controller' => 'Authentication', 'action' => 'signIn']);
$router->add('signup', ['controller' => 'Authentication', 'action' => 'signUp']);
$router->add('login', ['controller' => 'Authentication', 'action' => 'login']);
$router->add('register', ['controller' => 'Authentication', 'action' => 'register']);
$router->add('logout', ['controller' => 'Authentication', 'action' => 'logout']);
$router->add('{controller}/{action}');
$router->add('{controller}/{id:\d+}/{action}');

$router->dispatch($_SERVER['QUERY_STRING']);
