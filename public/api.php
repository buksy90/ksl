<?php
// If CORS Preflight request is made
// response with preflight headers
if($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: content-type');
    header('Access-Control-Max-Age: 86400'); // 24 hours
    header('Access-Control-Allow-Origin: *');
    //header('Access-Control-Expose-Headers: Content-Length');
    exit();
}

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


use GraphQL\GraphQL;
use GraphQL\Error\Debug;

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

require __DIR__.'/schema.php';


$rawInput = file_get_contents('php://input');
$input = json_decode($rawInput, true);
$query = $input['query'];
$variableValues = isset($input['variables']) ? $input['variables'] : null;

try {
    $result = GraphQL::executeQuery($schema, $query, null, null, $variableValues);

    $debug = Debug::INCLUDE_DEBUG_MESSAGE | Debug::RETHROW_INTERNAL_EXCEPTIONS | Debug::INCLUDE_TRACE;
    $output = $result->toArray($debug);
} catch (\Exception $e) {
    $output = [
        'errors' => [
            [
                'message' => $e->getMessage()
            ]
        ]
    ];
}

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

die(json_encode($output));