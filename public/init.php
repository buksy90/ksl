<?php
define('DIR_ROOT', __DIR__.'/..');
require DIR_ROOT.'/KSL/config.php';
require DIR_ROOT.'/KSL/vendor/autoload.php';


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


session_start();