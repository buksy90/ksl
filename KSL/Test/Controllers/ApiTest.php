<?php

namespace KSL\Test\Controllers;

class ApiTest extends TestBaseControllers {

    public function testApiReturns200() {     
        $response       = $this->getRouteResponse('/api.php', 'POST');
        $body = $response->getBody();
        $body->seek(0);

        $this->assertSame($response->getStatusCode(), 200);
    }

    public function testEmptyRequestReturnsEOF() {
        $response       = $this->getRouteResponse('/api.php', 'POST');
        $body = $response->getBody();
        $body->seek(0);
        
        $result = json_decode($body->read(1024));
        
        $this->assertSame("Syntax Error: Unexpected <EOF>", $result->errors[0]->message);
    }

    public function testTeamsQuery() {     
        $response       = $this->getRouteResponse('/api.php', 'POST', [
            'query' => '{ teams { name } }'
        ]);
        $body = $response->getBody();
        $body->seek(0);
        
        $result = json_decode($body->read(1024));
        //var_dump($result);
        //die("TESTEE2");
        $this->assertSame("Syntax Error: Unexpected <EOF>", $result->errors[0]->message);
    }

}