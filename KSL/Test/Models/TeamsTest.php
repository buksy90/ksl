<?php

namespace KSL\Test\Models;

use KSL\Models\Teams;

class TeamsTest extends TestBase {

    public function testGetCaptain() {
        $team       = Teams::find(1);
        $captain    = $team->GetCaptain();

        $this->assertInstanceOf('KSL\Models\Players', $captain);
        $this->assertEquals(1, $captain->id);
    }
    

    public function testGetStanding() {
        $team       = Teams::find(1);
        $standing   = $team->GetStanding();

        $this->assertTrue(is_object($standing));
        $this->assertEquals(1, $standing->id);
        $this->assertEquals('Bulls', $standing->name);
        $this->assertEquals('BUL', $standing->short);
        $this->assertEquals(1, $standing->captain_id);
        $this->assertEquals(1, $standing->games_won);
        $this->assertEquals(0, $standing->games_lost);
        $this->assertEquals(0, $standing->games_tied);
        $this->assertEquals(1, $standing->games_played);
        $this->assertEquals(11, $standing->points_scored);
        $this->assertEquals(2, $standing->points_allowed);
        $this->assertEquals(3, $standing->points);
        $this->assertEquals(100, $standing->success_rate);

        // Test that result should have 12 properties
        $this->assertEquals(12, count((array)$standing));
    }
    
    public function testGetStandings($teamId = null, Models\Base $modelInstance = null) {
        $standing   = Teams::GetStandings(2);

        $this->assertTrue(is_object($standing));
        $this->assertEquals(2, $standing->id);
        $this->assertEquals('Team A', $standing->name);
        $this->assertEquals('TEA', $standing->short);
        $this->assertEquals(4, $standing->captain_id);
        $this->assertEquals(0, $standing->games_won);
        $this->assertEquals(1, $standing->games_lost);
        $this->assertEquals(0, $standing->games_tied);
        $this->assertEquals(1, $standing->games_played);
        $this->assertEquals(2, $standing->points_scored);
        $this->assertEquals(11, $standing->points_allowed);
        $this->assertEquals(0, $standing->points);
        $this->assertEquals(0, $standing->success_rate);

        // Test that result should have 12 properties
        $this->assertEquals(12, count((array)$standing)); 
    }
    
    
    public function testGetPlayersCount() {
        $this->assertEquals(3, Teams::find(1)->GetPlayersCount());
        $this->assertEquals(3, Teams::find(2)->GetPlayersCount());
        $this->assertEquals(0, Teams::find(3)->GetPlayersCount());
    }
    
    
    public function testGetPlayers() {
        $players = Teams::find(1)->GetPlayers();
        $this->assertEquals(3, $players->count());
        $players = Teams::find(2)->GetPlayers();
        $this->assertEquals(3, $players->count());
        $players = Teams::find(3)->GetPlayers();
        $this->assertEquals(0, $players->count());
    }
    
    
    public function testGetGames() {
        $games = Teams::find(1)->GetGames();
        $this->assertEquals(2, $games->count());

        $games = Teams::find(3)->GetGames();
        $this->assertEquals(0, $games->count());
    }
    
    
    public function testGetBestShooter() {
        $team       = Teams::find(1);
        $shooter    = $team->GetBestShooter();
        $this->assertTrue(is_array($shooter));
        $this->assertEquals(2, count($shooter));
        $this->assertEquals(8, $shooter['score']);
        $this->assertInstanceOf('KSL\Models\Players', $shooter['player']);
        $this->assertEquals(1, $shooter['player']->id);


        $team       = Teams::find(3);
        $shooter    = $team->GetBestShooter();
        $this->assertNull($shooter);
    }
    
    
    public function testGetHistory() {
        $team       = Teams::find(1);
        $history    = $team->GetHistory();
        $this->assertTrue(is_array($history));
        $this->assertEquals(1, $history['won']);
        $this->assertEquals(0, $history['lost']);

        $team       = Teams::find(2);
        $history    = $team->GetHistory();
        $this->assertTrue(is_array($history));
        $this->assertEquals(0, $history['won']);
        $this->assertEquals(1, $history['lost']);

        $team       = Teams::find(3);
        $history    = $team->GetHistory();
        $this->assertTrue(is_array($history));
        $this->assertEquals(0, $history['won']);
        $this->assertEquals(0, $history['lost']);
    }
    
    
    public function testGetList() {
        $teams  = Teams::GetList();
        $this->assertEquals(3, $teams->count());
    }
    
    
    public function testGetTeamsIndexedArray() {
       $teams       = Teams::GetTeamsIndexedArray();
       $this->assertTrue(is_array($teams));
       $this->assertEquals(3, count($teams));
       
       foreach($teams as $index => $team) {
           $this->assertInstanceOf('KSL\Models\Teams', $team);
           $this->assertEquals($team->id, $index);
       }
       
   }
   
   
   public function testGetTeamsNames() {
        $teams = Teams::GetTeamsNames();
        $this->assertEquals(3, $teams->count());
        
        foreach($teams as $team) {
            $teamArray = $team->toArray();
            $this->assertEquals(2, count($teamArray));

            $this->assertTrue(array_key_exists('name', $teamArray));
            $this->assertTrue(array_key_exists('short', $teamArray));
        }
   }
}