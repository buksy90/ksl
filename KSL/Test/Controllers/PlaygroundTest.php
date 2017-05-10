<?php

namespace KSL\Test\Controllers;

use KSL\Controllers\Playground;

class PlaygroundTest extends TestBase {
     public function testShowList() {
        $environment = \Slim\Http\Environment::mock([
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI' => '/playground'
        ]);

        $request    = \Slim\Http\Request::createFromEnvironment($environment);
        $response   = new \Slim\Http\Response();

        $playground = new Playground($this->app->getContainer());
/*
        $playground = $this->getMockBuilder(Playground::class)
            ->setMethods(['all'])
            ->disableOriginalConstructor()
            ->getMock();
*/

        $response   = $playground->showList($request, $response, []);
        //$this->assertSame((string)$response->getBody(), '{"foo":"bar"}');
   }
}