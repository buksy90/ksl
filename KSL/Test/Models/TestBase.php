<?php

namespace KSL\Test\Models;


class TestBase extends \KSL\Test\TestBase {
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