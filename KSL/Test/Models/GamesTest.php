<?php

namespace KSL\Test\Models;

use KSL\Models\Games;

class GamesTest extends TestBase {
    public function testGetHomeTeamReturnsTeam() {
        $randomGame = Games::first();
        
        if($randomGame instanceof Games) {
            $homeTeam = $randomGame->GetHomeTeam();
            $this->assertInstanceOf('KSL\Models\Teams', $homeTeam);
            $this->assertEquals($homeTeam->id, $randomGame->hometeam);
        }
    }


    public function testGetAwayTeamReturnsTeam() {
        $randomGame = Games::first();
        
        if($randomGame instanceof Games) {
            $awayTeam = $randomGame->GetAwayTeam();
            $this->assertInstanceOf('KSL\Models\Teams', $awayTeam);
            $this->assertEquals($awayTeam->id, $randomGame->awayteam);
        }
    }


    
    /*
    public function testScopePlayedBy() {
        $result = Games::playedBy(1);

        $this->assertEquals(1, $result->count());
        var_dump($result);
    }
    */


    
    public function testScopeWonBy() {
        $result = Games::wonBy(1);
        $this->assertEquals(1, $result->count());

        $result = Games::wonBy(2);
        $this->assertEquals(0, $result->count());
    }
    
    public function testScopeLostBy() {
        $result = Games::lostBy(1);
        $this->assertEquals(0, $result->count());

        $result = Games::lostBy(2);
        $this->assertEquals(1, $result->count());
    }
    

    public function testGetNextAtPlayground() {
        $game = Games::getNextAtPlayground(1);
        $this->assertEquals(1, $game->count());

        $game = Games::getNextAtPlayground(1, 0);
        $this->assertEquals(0, $game->count());
    }


    public function testGetListOfDates() {
        $dates = Games::GetListOfDates(1, 0);
        
        $this->assertEquals(2, $dates->count());
        $this->assertEquals(1485900000, $dates[0]);
        $this->assertEquals(1738360800, $dates[1]);
    }

    public function testGetNextDayDate() {
        $date = Games::GetNextDayDate();
        $this->assertEquals(1738360800, $date);
    }


    public function testGetNextGames() {
        $date = Games::GetNextXDayDate(1);
        $this->assertEquals(1738360800, $date);
        $date = Games::GetNextXDayDate(0);
        $this->assertEquals(1738360800, $date);
        $date = Games::GetNextXDayDate(5);
        $this->assertEquals(null, $date);
    }
}