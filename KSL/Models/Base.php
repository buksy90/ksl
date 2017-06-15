<?php
namespace KSL\Models;

class Base extends \Illuminate\Database\Eloquent\Model
{
    // http://stackoverflow.com/a/24477971/619616
    public static function getTableName()
    {
        $instance = with(new static);
        return $instance->getConnection()->getTablePrefix() . $instance->getTable();
    }
}