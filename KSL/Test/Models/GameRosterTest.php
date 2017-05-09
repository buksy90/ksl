<?php

namespace KSL\Test\Models;

use KSL\Models\GameRoster;

class GameRosterTest extends TestBase {

    public function testGetPlayerGamesCount() {
        $gameRoster = GameRoster::GetPlayerGamesCount(1);
        $this->assertEquals(1, $gameRoster);

        $gameRoster = GameRoster::GetPlayerGamesCount(7);
        $this->assertEquals(0, $gameRoster);
    }
}