<?php

/* 
 * bootstrap file containing some basic configuration and loading
 */
define('_BASEPATH_', __DIR__ . '/');
define('_LIBS_', _BASEPATH_ . 'libs/');
define('_TMP_', _BASEPATH_ . 'tmp/');
define('_CONTROLLERS_', _BASEPATH_ . 'controllers/');

// get base URL, without subdir if exists
$base = $_SERVER['PHP_SELF'];
$idx = strrpos($base, '/');
define('_BASEURL_', substr($_SERVER['PHP_SELF'], 0, $idx));

// get URI without base path
$idx = strpos($_SERVER['REQUEST_URI'], _BASEURL_) + strlen(_BASEURL_);
$uri = substr($_SERVER['REQUEST_URI'], $idx);
unset($base, $idx);

$refreshAutoloaderCache = true;
require_once _LIBS_ . 'autoloader.php';
autoloader::init($refreshAutoloaderCache);

$router = new router($uri);

// load the controller
$controller = $router->getController();
$controller = new $controller();

$method = $router->getMethod();
