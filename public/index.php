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
require DIR_ROOT.'/vendor/autoload.php';


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
        //[ 'route' => 'o-nas', 'text' => 'O nás', 'navigationSwitch' => 'o-nas' ],
        [ 'route' => 'playground', 'text' => 'Ihriská', 'navigationSwitch' => 'playground' ],
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

$app->get('/liga/o-nas', function ($request, $response, $args) {
    return $response->write( $this->twig->render('o-nas.tpl', [
        'navigationSwitch' => 'liga'
    ]));
})->setName('o-nas');
$app->get('/liga/pravidla', function ($request, $response, $args) {
    return $response->write( $this->twig->render('pravidla.tpl', [
        'navigationSwitch' => 'liga'
    ]));
})->setName('pravidla');
$app->get('/liga/pokuty-poplatky', function ($request, $response, $args) {
    return $response->write( $this->twig->render('pokuty_poplatky.tpl', [
        'navigationSwitch' => 'liga'
    ]));
})->setName('pokuty-poplatky');

$app->get('/', '\KSL\Controllers\Index:show')->setName('index');
$app->get('/rozpis', '\KSL\Controllers\Rozpis:show')->setName('rozpis');
$app->get('/tabulka', '\KSL\Controllers\Tabulka:show')->setName('tabulka');
$app->get('/nova-sezona', '\KSL\Controllers\NovaSezona:show')->setName('nova-sezona');
$app->post('/nova-sezona/generate', '\KSL\Controllers\NovaSezona:generate')->setName('nova-sezona#generate');
$app->get('/nova-sezona/save', '\KSL\Controllers\NovaSezona:save')->setName('nova-sezona#save');
$app->get('/playground', '\KSL\Controllers\Playground:showList')->setName('playground');
$app->get('/playground/{link}', '\KSL\Controllers\Playground:showPlayground')->setName('playgroundByLink');
$app->get('/teams', '\KSL\Controllers\Teams:show')->setName('timy');
$app->get('/teams/{short}', '\KSL\Controllers\Teams:showTeam')->setName('tim');
$app->get('/players/{seo}', '\KSL\Controllers\Players:showPlayer')->setName('player');

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
