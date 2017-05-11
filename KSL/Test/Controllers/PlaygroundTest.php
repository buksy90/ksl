<?php

namespace KSL\Test\Controllers;

class PlaygroundTest extends TestBaseControllers {

    public function testShowPlayground() {     
        $playground     = \KSL\Models\Playground::first();
        $response       = $this->getRouteResponse('/playground/'.$playground->link);
        $this->assertSame($response->getStatusCode(), 200);
    }


    public function testShowPlaygroundThatDoesntExist() {   
        $response = $this->getRouteResponse('/playground/fakeThatDoesntExist');
        $this->assertSame($response->getStatusCode(), 404);
    }


    public function testGetPlayground() {
        $playground = \KSL\Models\Playground::first();
        $controller = new \KSL\Controllers\Playground($this->app->getContainer());
        $config     = $controller->getPlayground($playground);

        $this->assertTrue($config->isValid());
        $this->assertEquals('playground.tpl', $config->file);
        $this->assertEquals($playground, $config->variables['playground']);
        $this->assertEquals(1, count($config->variables['games']));
    }

   
}