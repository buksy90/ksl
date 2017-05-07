<?php

namespace KSL\Test\Models;

use KSL\Models\Games;

class GamesTest extends \PHPUnit_Framework_TestCase {
    public function testGetHomeTeamReturnsTeam() {
        $randomGame = Games::first();
        $this->assertTrue(false);
    }
}