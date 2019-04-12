<?php
$origin = array_key_exists('HTTP_ORIGIN', $_SERVER)
? $_SERVER['HTTP_ORIGIN']
: (array_key_exists('HTTP_REFERER', $_SERVER)
    ? $_SERVER['HTTP_REFERER']
    : $_SERVER['REMOTE_ADDR']);

header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: content-type, cookie');
header('Access-Control-Max-Age: 86400'); // 24 hours
header('Access-Control-Allow-Origin: '.$origin);
header('Access-Control-Allow-Credentials: true');

// If CORS Preflight request is made
// response only with preflight headers
if($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit();
}


require 'init.php';
use GraphQL\GraphQL;
use GraphQL\Error\Debug;

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

die(json_encode($output));