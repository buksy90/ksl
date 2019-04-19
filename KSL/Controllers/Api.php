<?php
namespace KSL\Controllers;

use GraphQL\GraphQL;
use GraphQL\Error\Debug;

class Api extends Base
{
    private $allowedOrigins = ['http://localhost/', 'http://localhost:', 'http://ksl.sk/', 'chrome-extension://', 'phpunit://'];

    public function show($request, $response, $args) {
        $response = $this->sendHeaders($this->getOrigin(), $response);
        $input = json_decode($this->getInput(), true);
        $query = $input['query'];
        $variableValues = isset($input['variables']) ? $input['variables'] : null;

        $result = $this->execute($query, $variableValues);
        return $response->write(json_encode($result));
   }

    public function showOptions($request, $response, $args) {
        $response = $this->sendHeaders($this->getOrigin(), $response);
        return $response;
    }

    public function execute($query, $variableValues) {
        $output = null;

        try {
            $result = GraphQL::executeQuery($this->getSchema(), $query, null, null, $variableValues);    
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

        return $output;
    }

    public function getOrigin() {
        return array_key_exists('HTTP_ORIGIN', $_SERVER)
            ? $_SERVER['HTTP_ORIGIN']
            : (array_key_exists('HTTP_REFERER', $_SERVER)
                ? $_SERVER['HTTP_REFERER']
                : (array_key_exists('REMOTE_ADDR', $_SERVER)
                    ? $_SERVER['REMOTE_ADDR']
                    : 'phpunit://'
                    ));
    }

    public function sendHeaders($origin, $response) {
        $origin = $this->getOrigin();
        $isAllowed = count(array_filter($this->allowedOrigins, function($allowed) use ($origin) { return strstr($origin, $allowed) !== false; })) == 1;

        if($isAllowed == false) {
            http_response_code(403);
            die('Forbidden for '.$origin);
        }

        return $response
            ->withHeader('Access-Control-Allow-Methods', 'POST')
            ->withHeader('Access-Control-Allow-Headers', 'content-type, cookie')
            ->withHeader('Access-Control-Max-Age', '86400')
            ->withHeader('Access-Control-Allow-Origin', $origin)
            ->withHeader('Access-Control-Allow-Credentials', 'true');
    }

    private function getSchema() {
        $schema = require DIR_ROOT.'/public/schema.php';
        return $schema;
    }

    private function getInput() {
        return array_key_exists('argv', $_SERVER) && strpos($_SERVER['argv'][0], 'phpunit') !== FALSE
            ? $_POST['input']
            : file_get_contents('php://input');
    }
}