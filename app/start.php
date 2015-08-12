<?php

use Slim\Slim;
use Noodlehaus\Config;
use Titanhomes\User\User;

session_cache_limiter(false);
session_start();

//Set errors to display
ini_set('display_errors', 'On');

define('INC_ROOT', dirname(__DIR__));

/*
* Protected data like passwords, accounts, and keys
* are moved outside of the workspace directory.
* Changes can be made to secrets via nano editor
*/
include '../../secrets/secrets.php';
include INC_ROOT . '/vendor/autoload.php';

$app = new Slim([
    'mode' => file_get_contents(INC_ROOT . '/mode.php')
]);

$app->configureMode($app->config('mode'), function() use ($app) {
   $app->config = Config::load(INC_ROOT . "/app/config/{$app->mode}.php"); 
});

require 'database.php';

//Adds user class to Slim's container
$app->container->set('user', function() {
    return new User;
});