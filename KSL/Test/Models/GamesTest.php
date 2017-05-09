<?php

namespace KSL\Test\Models;

use KSL\Models\Games;

class GamesTest extends TestBase {
    public function testGetHomeTeamReturnsTeam() {
        $randomGame = Games::first();
        
        $homeTeam = $randomGame->GetHomeTeam();
        $this->assertInstanceOf('KSL\Models\Teams', $homeTeam);
        $this->assertEquals($homeTeam->id, $randomGame->hometeam);
    }


    public function testGetAwayTeamReturnsTeam() {
        $randomGame = Games::first();
        
        $awayTeam = $randomGame->GetAwayTeam();
        $this->assertInstanceOf('KSL\Models\Teams', $awayTeam);
        $this->assertEquals($awayTeam->id, $randomGame->awayteam);
    }


    /*
    public function scopePlayedBy($query, $teamId) {
        return $query->where('hometeam', $teamId)->orWhere('awayTeam', $teamId);
    }
    
    public function scopeWonBy($query, $teamId) {
        return $query->where([['hometeam', $teamId], ['won', 'home']])->orWhere([['awayTeam', $teamId], ['won', 'away']]);
    }
    
    public function scopeLostBy($query, $teamId) {
        return $query->where([['hometeam', $teamId], ['won', 'away']])->orWhere([['awayTeam', $teamId], ['won', 'home']]);
    }
    */
}