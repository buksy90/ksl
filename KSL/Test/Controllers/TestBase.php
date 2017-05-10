<?php

namespace KSL\Test\Controllers;

define('DIR_ROOT', __DIR__.'/../../..');

class TestBase extends \PHPUnit_Framework_TestCase {
    private static $isSetUp = false;
    protected $app = null;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        if(Self::$isSetUp === false) {
            require DIR_ROOT.'/KSL/config_test_env.php';

            $capsule = new \Illuminate\Database\Capsule\Manager;
            $capsule->addConnection($config['db']);

            $capsule->setAsGlobal();
            $capsule->bootEloquent();
        }
    }

    public function setUp() {
        parent::setUp();
        $this->setUpSlim();
    }

    private function setUpSlim() {
        require DIR_ROOT.'/KSL/config_test_env.php';

        //$container = new \Slim\Container;
        //$app = new \Slim\App($container);
        $app        = new \Slim\App(['settings' => $config]);
        $container  = $app->getContainer();
        $container['twig'] = \KSL\Templates::getTwig($container);

        \KSL\Routes::set($app);

        $this->app = $app;
    }

}