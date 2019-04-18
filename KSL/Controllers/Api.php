<?php
namespace KSL\Controllers;

use GraphQL\GraphQL;
use GraphQL\Error\Debug;

class Api extends Base
{
    private $allowedOrigins = ['http://localhost/', 'http://localhost:', 'http://ksl.sk/', 'chrome-extension://'];

    public function show($request, $response, $args) {
        $this->sendHeaders($this->getOrigin());

        // If CORS Preflight request is made
        // response only with preflight headers
        if($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            exit();
        }
        
        $rawInput = file_get_contents('php://input');
        $input = json_decode($rawInput, true);
        $query = $input['query'];
        $variableValues = isset($input['variables']) ? $input['variables'] : null;
        
        $result = $this->execute($query, $variableValues);

        return $response->write(json_encode($result));
   }

    public function showOptions($request, $response, $args) {
        $this->sendHeaders($this->getOrigin());
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
                : $_SERVER['REMOTE_ADDR']);
   }

   public function sendHeaders($origin) {
        $origin = $this->getOrigin();
        $isAllowed = count(array_filter($this->allowedOrigins, function($allowed) use ($origin) { return strstr($origin, $allowed) !== false; })) == 1;

        if($isAllowed == false) {
            http_response_code(403);
            die('Forbidden for '.$origin);
        }

        header('Access-Control-Allow-Methods: POST');
        header('Access-Control-Allow-Headers: content-type, cookie');
        header('Access-Control-Max-Age: 86400'); // 24 hours
        header('Access-Control-Allow-Origin: '.$origin);
        header('Access-Control-Allow-Credentials: true');
   }

   private function getSchema() {
        $schema = require DIR_ROOT.'/public/schema.php';
        return $schema;
   }
}