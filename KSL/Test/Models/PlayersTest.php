<?php

namespace KSL\Test\Models;

use KSL\Models\Players;

class PlayersTest extends TestBase {

    public function testGetTeam() {
        $jordan = Players::find(1);
        $team   = $jordan->GetTeam();

        $this->assertInstanceOf('KSL\Models\Teams', $team);
        $this->assertEquals(1, $team->id);
    }

    public function testGenerateSEOGlobally() {
        $players = Players::query();
        $players->update(['seo' => null]);

        Players::GenerateSEOGlobally();

        $noSeoPlayers = Players::Where(['seo' => null]);
        $this->assertEquals(0, $noSeoPlayers->count());
    }


    public function testGenerateSEO() {
        $jordan = Players::find(1);
        $this->assertEquals('Air Jordan', $jordan->nick);
        $this->assertEquals('air_jordan', $jordan->seo);

        $jordan = Players::find(3);
        $this->assertEquals('Scottie', $jordan->name);
        $this->assertEquals('Pippen', $jordan->surname);
        $this->assertEquals('scottie_pippen', $jordan->seo);
    }


    public function testGetGamesCount() {
        $jordan = Players::find(1);
        $this->assertEquals(1, $jordan->GetGamesCount());

        $freeAgent = Players::find(7);
        $this->assertEquals(0, $freeAgent->GetGamesCount());
    }


    public function testGetPointsSum($only3pt = null, $allSeasons = null) {        
        $jordan = Players::find(1);
        $this->assertEquals(8, $jordan->GetPointsSum());
        $this->assertEquals(0, $jordan->GetPointsSum(true));

        $pippen = Players::find(3);
        $this->assertEquals(3, $pippen->GetPointsSum());
        $this->assertEquals(1, $pippen->GetPointsSum(true));
    }


    public function testGetPlayersBySeason() {
        $players = Players::GetPlayersBySeason(1);

        $this->assertEquals(6, count($players));
   }


   public function testGetRank() {
       $jordan = Players::find(1);
       $this->assertEquals(1, $jordan->getRank());

       $pippen = Players::find(3);
       $this->assertEquals(2, $pippen->getRank());

       $rodman = Players::find(2);
       $this->assertEquals(4, $rodman->getRank());
   }


   public function testGetOverall() {
       $jordan = Players::find(1);
       $this->assertEquals(99, $jordan->GetOverall());

       $pippen = Players::find(3);
       $this->assertEquals(98, $pippen->GetOverall());

       $rodman = Players::find(2);
       $this->assertEquals(96, $rodman->GetOverall());
   }
}