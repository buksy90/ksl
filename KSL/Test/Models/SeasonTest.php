<?php

namespace KSL\Test\Models;

use KSL\Models\Season;

class SeasonTest extends TestBase {
    public function testGetActual() {
        $season = Season::GetActual();

        $this->assertEquals(1, $season->count());
        $this->assertInstanceOf('KSL\Models\Season', $season);
    }


    public function testGetActualYear() {
        $this->assertEquals(date('Y'), Season::GetActualYear());
    }
}