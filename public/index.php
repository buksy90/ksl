<?php
session_start();

/**
 * Step 1: Require the Slim Framework using Composer's autoloader
 *
 * If you are not using Composer, you need to load Slim Framework with your own
 * PSR-4 autoloader.
 */
define('DIR_ROOT', __DIR__.'/..');
require DIR_ROOT.'/KSL/config.php';
require DIR_ROOT.'/KSL/vendor/autoload.php';


use \Illuminate\Database\Connection;
use \KSL\Models;
use \KSL\Controllers;


$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($config['db']);

$capsule->setAsGlobal();
$capsule->bootEloquent();



/**
 * Step 2: Instantiate a Slim application
 *
 * This example instantiates a Slim application using
 * its default settings. However, you will usually configure
 * your Slim application now by passing an associative array
 * of setting names and values into the application constructor.
 */
$app        = new Slim\App(['settings' => $config]);
$container  = $app->getContainer();


// DB Connection 
// TODO: 
// This shouldn't be needed as models have their own pointer to db instance
// Right now, only controllers are using this, but all db logic should be moved
// from controllers to models
$container['connection'] = function($c) use ($capsule) {
    return $capsule->getConnection();
};


$container['twig']  = \KSL\Templates::getTwig($app->getContainer());


\KSL\Routes::set($app);


$app->run();