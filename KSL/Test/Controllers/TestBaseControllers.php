<?php

namespace KSL\Test\Controllers;

class TestBaseControllers extends \KSL\Test\TestBase {
    protected $app = null;

    public function setUp() {
        parent::setUp();
        $this->setUpSlim();
    }

    private function setUpSlim() {
        $app        = new \Slim\App(['settings' => self::$config]);
        $container  = $app->getContainer();
        $container['twig'] = \KSL\Templates::getTwig($container);

        \KSL\Routes::set($app);

        $this->app = $app;
    }

    protected function getRouteResponse($route, $method = 'GET', $input = null) {
        $environment    = \Slim\Http\Environment::mock([
            'REQUEST_METHOD' => $method,
            'REQUEST_URI' => $route
        ]);

        $_POST['input'] = json_encode($input);

        $request    = \Slim\Http\Request::createFromEnvironment($environment);
        $request->withParsedBody(["a" => 4]);

        $this->app->getContainer()['request'] = $request;
        return $this->app->run(true);
    }
}