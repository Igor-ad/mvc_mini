<?php

use App\Utils\Router;

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'autoload.php';

$autoloader = new Psr4AutoloaderClass();
$autoloader->addNamespace('App', __DIR__ . '/../src');
$autoloader->register();

require __DIR__ . '/../helpers.php';

$router = new Router();
$router->process();