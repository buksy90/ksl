<?php
// If CORS Preflight request is made
// response with preflight headers
if($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: content-type, cookie');
    header('Access-Control-Max-Age: 86400'); // 24 hours
    header('Access-Control-Allow-Origin: *');
    //header('Access-Control-Expose-Headers: Content-Length');
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

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

die(json_encode($output));