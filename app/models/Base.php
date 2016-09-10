<?php
namespace KSL\Models;

class Base extends \Illuminate\Database\Eloquent\Model
{
    // http://stackoverflow.com/a/24477971/619616
    public static function getTableName()
    {
        return with(new static)->getTable();
    }
    
    
    //protected $connection;
    
    public function __construct(array $attributes = []) {
        //$this->connection = static::$_ci;
        
        //return call_user_func_array(array('parent', '__construct'), func_get_args());
        parent::__construct($attributes);
    }
        
    
    //public function __construct(ContainerInterface $ci);
    protected static $_connection;
    public static function SetContainer($ci) {
        return static::$_connection = $ci->connection;
    }
}