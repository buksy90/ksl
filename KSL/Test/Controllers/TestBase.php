<?php

namespace KSL\Test\Controllers;

define('DIR_ROOT', __DIR__.'/../../..');

class TestBase extends \PHPUnit_Framework_TestCase {
    private static $isSetUp = false;

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


}