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
            'query' => '{ teams { id, name, short, captain { id } } }'
        ]);
        $body = $response->getBody();
        $body->seek(0);
        
        $result = json_decode($body->read(1024));
        $teams = $result->data->teams;

        $this->assertCount(3, $teams);
        $this->assertTrue($this->compareObjects(['id' => 1, 'name' => 'Bulls', 'short' => 'BUL', 'captain' => [ 'id' => 1 ] ], $teams[0]));
        $this->assertTrue($this->compareObjects(['id' => 2, 'name' => 'Team A', 'short' => 'TEA', 'captain' => [ 'id' => 4 ] ], $teams[1]));
        $this->assertTrue($this->compareObjects(['id' => 3, 'name' => 'Team X', 'short' => 'X', 'captain' => null ], $teams[2]));
    }

}