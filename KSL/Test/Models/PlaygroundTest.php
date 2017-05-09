<?php

namespace KSL\Test\Models;

use KSL\Models\Playground;

class PlaygroundTest extends TestBase {

    public function testGetList() {
        $this->assertTrue(Playground::GetList()->count() > 0);
    }
}