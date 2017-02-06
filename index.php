<?php
error_reporting(E_ALL); 
ini_set('display_errors','On');

// DEBUG SETTINGS
// No need for more, and infinite cycles will be found easier
set_time_limit(1);
ini_set('memory_limit', '12M');
session_start();

/**
 * Step 1: Require the Slim Framework using Composer's autoloader
 *
 * If you are not using Composer, you need to load Slim Framework with your own
 * PSR-4 autoloader.
 */
define('DIR_ROOT', __DIR__);
require DIR_ROOT.'/vendor/autoload.php';

use \Illuminate\Database\Connection;
use \KSL\Models;
use \KSL\Controllers;


$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$config['db']['driver']         = 'mysql';
$config['db']['host']           = getenv('IP');
$config['db']['username']       = getenv('C9_USER');
$config['db']['password']       = '';
$config['db']['database']       = 'c9';
$config['db']['collation']      = 'utf8_general_ci';
$config['db']['charset']        = 'utf8';
$config['db']['port']           = 3306;

$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($config['db']);

$capsule->setAsGlobal();
$capsule->bootEloquent();



spl_autoload_register(function ($classname) {
    if(substr($classname, 0, 11) === 'KSL\Models\\')
        require_once(DIR_ROOT . '/app/models/' . substr($classname, 11) . ".php");
        
    return false;
});


spl_autoload_register(function ($classname) {
    if(substr($classname, 0, 16) === 'KSL\Controllers\\') {
        require_once(DIR_ROOT . '/app/controllers/' . substr($classname, 16) . ".php");
    }
        
        
    return false;
});


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



//
// Set up twig
//
$container['twig']  = function($c) {
    $loader         = new Twig_Loader_Filesystem(DIR_ROOT.'/views');
    $env            = new Twig_Environment($loader, array(
        //'cache' => '/cache'
        'debug'                 => true,
        'strict_variables'      => true
    ));
    
    $env->addExtension(new Twig_Extension_Debug());
    
    $env->addGlobal('router', $c['router']);
    $env->addGlobal('navigation', null);
    
    $env->addGlobal('navigation', [
        [ 'route' => 'index', 'text' => 'Úvod', 'navigationSwitch' => null ],
        [ 'route' => 'rozpis', 'text' => 'Rozpis', 'navigationSwitch' => 'rozpis' ],
        [ 'route' => 'tabulka', 'text' => 'Tabuľky', 'navigationSwitch' => 'tabulka' ],
        [ 'route' => 'o-nas', 'text' => 'O nás', 'navigationSwitch' => 'o-nas' ],
        [ 'route' => 'ihrisko', 'text' => 'Ihriská', 'navigationSwitch' => 'ihrisko' ],
    ]);


    $env->addGlobal('teamsNames', Models\Teams::GetTeamsNames());

    return $env;
};

/**
 * Step 3: Define the Slim application routes
 *
 * Here we define several Slim application routes that respond
 * to appropriate HTTP request methods. In this example, the second
 * argument for `Slim::get`, `Slim::post`, `Slim::put`, `Slim::patch`, and `Slim::delete`
 * is an anonymous function.
 */
 /*
$app->get('/', function ($request, $response, $args) {
    return $response->write( $this->twig->render('layout.tpl', [
        'navigationSwitch' => null
    ]));
})->setName('index');
*/

$app->get('/o-nas', function ($request, $response, $args) {
    return $response->write( $this->twig->render('o-nas.tpl', [
        'navigationSwitch' => 'o-nas'
    ]));
})->setName('o-nas');

$app->get('/', '\KSL\Controllers\Index:show')->setName('index');
$app->get('/rozpis', '\KSL\Controllers\Rozpis:show')->setName('rozpis');
$app->get('/tabulka', '\KSL\Controllers\Tabulka:show')->setName('tabulka');
$app->get('/nova-sezona', '\KSL\Controllers\NovaSezona:show')->setName('nova-sezona');
$app->post('/nova-sezona/generate', '\KSL\Controllers\NovaSezona:generate')->setName('nova-sezona#generate');
$app->get('/nova-sezona/save', '\KSL\Controllers\NovaSezona:save')->setName('nova-sezona#save');
$app->get('/ihrisko', '\KSL\Controllers\Ihrisko:showList')->setName('ihrisko');
$app->get('/ihrisko/{link}', '\KSL\Controllers\Ihrisko:showPlayground')->setName('ihriskoByLink');
$app->get('/teams', '\KSL\Controllers\Teams:show')->setName('timy');
$app->get('/teams/{short}', '\KSL\Controllers\Teams:showTeam')->setName('tim');

/*
$app->get('/hello[/{name}]', function ($request, $response, $args) {
    $response->write("Hello, " . $args['name']);
    return $response;
})->setArgument('name', 'World!');
*/

/**
 * Step 4: Run the Slim application
 *
 * This method should be called last. This executes the Slim application
 * and returns the HTTP response to the HTTP client.
 */
$app->run();
