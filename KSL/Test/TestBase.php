<?php
namespace KSL\Test;

define('DIR_ROOT', __DIR__.'/../..');

class TestBase extends \PHPUnit_Framework_TestCase {
    private static $isSetUp = false;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        if(Self::$isSetUp === false) {
            if(getenv('TRAVIS') == true) require DIR_ROOT.'/KSL/config_travis_env.php';
            else require DIR_ROOT.'/KSL/config_test_env.php';

            var_dump(getenv('TRAVIS'));
            var_dump($config);

            $capsule = new \Illuminate\Database\Capsule\Manager;
            $capsule->addConnection($config['db']);

            $capsule->setAsGlobal();
            $capsule->bootEloquent();

            self::$isSetUp = true;
        }
    }
}