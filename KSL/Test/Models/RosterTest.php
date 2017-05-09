<?php

namespace KSL\Test\Models;

use KSL\Models\Roster;

class RosterTest extends TestBase {

    /**
     * @expectedException Exception
     */
    public function testScopeThisYear() {
        $roster = Roster::ThisYear();

        $this->assertEquals(6, $roster->count());
    }
    

    /**
     * @expectedException Exception
     */
    public function testScopeYear() {
        $roster = Roster::Year(2015);
        $this->assertEquals(6, $roster->count());
    }
}