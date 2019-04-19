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


    // Deeply compare two objects or arrays
    // @$obj1 array|object
    // @$obj2 array|object
    // returns true|string
    protected function compareObjects($obj1, $obj2) {
        if(is_object($obj1)) $obj1 = json_decode(json_encode($obj1), true);
        if(is_object($obj2)) $obj2 = json_decode(json_encode($obj2), true);

        if(is_array($obj1) === false || is_array($obj2) === false)
            return 'Cannot convert input to array';

        $keys = array_keys($obj1);

        if(count(array_keys($obj2)) != count($keys))
            return 'Objects have different number of properties';

        foreach($keys as $key) {
            // If obj2 misses any key of obj1
            if(array_key_exists($key, $obj2) === false)
                return 'Obj2 doesnt have following key: '.$key;

            $key1 = $obj1[$key];
            $key2 = $obj2[$key];
            
            // If both key1 & key2 are objects/arrays but not deeply equal
            if($this->isObjectOrArray($key1) && $this->isObjectOrArray($key2)) {
                if($this->compareObjects($key1, $key2) === false)
                    return 'Following key is not deeply equal: '.$key;
            }
            
            // or if key1 & key2 are scalar types but are not equal
            else if($key1 != $key2)
                return 'Following key is not equal: '.$key;
        }

        return true;
    }

    protected function isObjectOrArray($candidate) {
        return is_array($candidate) || is_object($candidate);
    }
}