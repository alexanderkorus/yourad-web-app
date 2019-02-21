<?php

/**
 * Front controller
 * User: Alexander Korus
 * Date: 2019-02-17
 */


require dirname(__DIR__) . '/vendor/autoload.php';

//Twig_Autoloader::register();


error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

$router = new Core\Router();

/*
 * GET Routes
 */
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('signin', ['controller' => 'Authentication', 'action' => 'signIn']);
$router->add('signup', ['controller' => 'Authentication', 'action' => 'signUp']);
$router->add('newpost', ['controller' => 'Post', 'action' => 'newPost']);
$router->add('category', ['controller' => 'Category', 'action' => 'index']);
$router->add('category/{id:\d+}', ['controller' => 'Category', 'action' => 'index']);
$router->add('category/{id:\d+}/search', ['controller' => 'Category', 'action' => 'search']);
$router->add('post/search', ['controller' => 'Post', 'action' => 'search']);
$router->add('post/add', ['controller' => 'Post', 'action' => 'addPost']);
$router->add('post/{id:\d+}', ['controller' => 'Post', 'action' => 'index']);


/*
 * POST Routes
 */
$router->add('login', ['controller' => 'Authentication', 'action' => 'login']);
$router->add('register', ['controller' => 'Authentication', 'action' => 'register']);
$router->add('logout', ['controller' => 'Authentication', 'action' => 'logout']);

/*
 * Default Routes
 */
//$router->add('{controller}/{action}');
//$router->add('{controller}/{id:\d+}/{action}');

$router->dispatch($_SERVER['QUERY_STRING']);
