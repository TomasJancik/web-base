<?php

/* 
 * bootstrap file containing some basic configuration and loading
 */
define('_BASEPATH_', __DIR__ . '/');
define('_LIBS_', _BASEPATH_ . 'libs/');
define('_TMP_', _BASEPATH_ . 'tmp/');
define('_CONTROLLERS_', _BASEPATH_ . 'controllers/');

define('_BASEURL_', $_SERVER['SERVER_NAME']);

$refreshAutoloaderCache = true;
require_once _LIBS_ . 'autoloader.php';
autoloader::init($refreshAutoloaderCache);

$router = new router($_SERVER['REQUEST_URI']);

// load the controller
$controller = $router->getController();
$controller = new $controller();

$method = $router->getMethod();
