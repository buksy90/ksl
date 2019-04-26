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

    public function testTeamsQueryStatistics() {
        $response       = $this->getRouteResponse('/api.php', 'POST', [
            'query' => '{ teams { standing, score, games_played, games_won, games_lost } }'
        ]);
        $body = $response->getBody();
        $body->seek(0);
        
        $result = json_decode($body->read(1024));
        //var_dump($result);
        $teams = $result->data->teams;

        $this->assertCount(3, $teams);
        $this->assertTrue($this->compareObjects(['standing' => 1, 'score' => "11:2", 'games_played' => 1, 'games_won' => 1, 'games_lost' => 0], $teams[0]));
        $this->assertTrue($this->compareObjects(['standing' => 2, 'score' => "2:11", 'games_played' => 1, 'games_won' => 0, 'games_lost' => 1], $teams[1]));
        $this->assertTrue($this->compareObjects(['standing' => 3, 'score' => "0:0", 'games_played' => 0, 'games_won' => 0, 'games_lost' => 0], $teams[2]));
    }

    public function testTeamsQueryStatistics2() {
        $response       = $this->getRouteResponse('/api.php', 'POST', [
            'query' => '{ teams { points, points_scored, points_allowed, success_rate } }'
        ]);
        $body = $response->getBody();
        $body->seek(0);
        
        $result = json_decode($body->read(1024));
        //var_dump($result);
        $teams = $result->data->teams;

        $this->assertCount(3, $teams);
        $this->assertTrue($this->compareObjects(['points' => 3, 'points_scored' => 11, 'points_allowed' => 2, 'success_rate' => 100], $teams[0]));
        $this->assertTrue($this->compareObjects(['points' => 0, 'points_scored' => 2, 'points_allowed' => 11, 'success_rate' => 0], $teams[1]));
        $this->assertTrue($this->compareObjects(['points' => 0, 'points_scored' => 0, 'points_allowed' => 0, 'success_rate' => 0], $teams[2]));
    }

}