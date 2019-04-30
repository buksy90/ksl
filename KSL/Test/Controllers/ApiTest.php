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

    public function testDateType() {
        $response       = $this->getRouteResponse('/api.php', 'POST', [
            'query' => '{ matches { date { timestamp, datetime, datetime_human, date } } }'
        ]);
        $body = $response->getBody();
        $body->seek(0);
        
        $result = json_decode($body->read(1024));
        //var_dump($result);
        $matches = $result->data->matches;

        $this->assertCount(2, $matches);
        $this->assertTrue($this->compareObjects(['timestamp' => 1262442600, 'datetime' => '2010-01-02T15:30:00+01:00', 'datetime_human' => 'Sat, 02 Jan 2010 15:30:00 +0100', 'date' => '2010-01-02'], $matches[0]->date));
        $this->assertTrue($this->compareObjects(['timestamp' => 1860762600, 'datetime' => '2028-12-18T15:30:00+01:00', 'datetime_human' => 'Mon, 18 Dec 2028 15:30:00 +0100', 'date' => '2028-12-18'], $matches[1]->date));
    }

    public function testMatchesQuery() {
        $response       = $this->getRouteResponse('/api.php', 'POST', [
            'query' => '{ matches {
                date { timestamp },
                home_team { id },
                away_team { id },
                home_score,
                away_score,
                played
              } }'
        ]);
        $body = $response->getBody();
        $body->seek(0);
        
        $result = json_decode($body->read(1024));
        $matches = $result->data->matches;

        $this->assertCount(2, $matches);
        $this->assertTrue($this->compareObjects(['date' => ['timestamp' => 1262442600], 'home_team' => ['id' => 1], 'away_team' => ['id' => 2], 'home_score' => 11, 'away_score' => 2, 'played' => true], $matches[0]));
        $this->assertTrue($this->compareObjects(['date' => ['timestamp' => 1860762600], 'home_team' => ['id' => 2], 'away_team' => ['id' => 1], 'home_score' => null, 'away_score' => null, 'played' => false], $matches[1]));
    }

    public function testMatchesQueryWithTeamArgument() {
        $response       = $this->getRouteResponse('/api.php', 'POST', [
            'query' => '{ matches(team_id: 1) {
                home_team { id },
                away_team { id },
                played
              } }'
        ]);
        $body = $response->getBody();
        $body->seek(0);
        
        $result = json_decode($body->read(1024));
        $matches = $result->data->matches;
        //var_dump($matches);

        $this->assertCount(2, $matches);
        $this->assertTrue($this->compareObjects(['home_team' => ['id' => 1], 'away_team' => ['id' => 2], 'played' => true], $matches[0]));
        $this->assertTrue($this->compareObjects(['home_team' => ['id' => 2], 'away_team' => ['id' => 1], 'played' => false], $matches[1]));
    }

    public function testMatchesQueryWithDateArgument() {
        $response       = $this->getRouteResponse('/api.php', 'POST', [
            'query' => '{ matches(date: "2010-01-02") {
                date { datetime }
                played
              } }'
        ]);
        $body = $response->getBody();
        $body->seek(0);
        
        $result = json_decode($body->read(1024));
        $matches = $result->data->matches;
        //var_dump($matches);
        
        $this->assertCount(1, $matches);
        $this->assertTrue($this->compareObjects(['date' => ['datetime' => '2010-01-02T15:30:00+01:00'], 'played' => true], $matches[0]));
    }

    public function testPlayerPoints() {
        $response       = $this->getRouteResponse('/api.php', 'POST', [
            'query' => '{ teams(id: 1) {
                current_roster { surname, matches_count, made_2pt, made_3pt }
              } }'
        ]);
        $body = $response->getBody();
        $body->seek(0);
        
        $result = json_decode($body->read(1024));
        $teams = $result->data->teams;
        $roster = $teams[0]->current_roster;
        //var_dump($teams);
        
        $this->assertCount(1, $teams);
        $this->assertCount(3, $roster);
        $this->assertTrue($this->compareObjects(['surname' => 'Jordan', 'matches_count' => 1, 'made_2pt' => 4, 'made_3pt' => 0], $roster[0]));
        $this->assertTrue($this->compareObjects(['surname' => 'Rodman', 'matches_count' => 1, 'made_2pt' => 0, 'made_3pt' => 0], $roster[1]));
        $this->assertTrue($this->compareObjects(['surname' => 'Pippen', 'matches_count' => 1, 'made_2pt' => 0, 'made_3pt' => 1], $roster[2]));
    }

    public function testTeamMatches() {
        $response       = $this->getRouteResponse('/api.php', 'POST', [
            'query' => '{ teams(id: 1) {
                matches { home_team { short }, away_team { short }, home_score, away_score, played }
              } }'
        ]);
        $body = $response->getBody();
        $body->seek(0);
        
        $result = json_decode($body->read(1024));
        $teams = $result->data->teams;
        $matches = $teams[0]->matches;
        //var_dump($matches);
        
        $this->assertCount(2, $matches);
        $this->assertTrue($this->compareObjects(['home_team' => ['short' => 'BUL'], 'away_team' => ['short' => 'TEA'], 'home_score' => 11, 'away_score' => 2, 'played' => true], $matches[0]));
        $this->assertTrue($this->compareObjects(['home_team' => ['short' => 'TEA'], 'away_team' => ['short' => 'BULL'], 'home_score' => null, 'away_score' => null, 'played' => false], $matches[1]));
    }

}