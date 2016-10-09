<?php
namespace KSL\Models;

class Playground extends Base
{
    //
    // https://laravel.com/docs/5.3/eloquent
    //
    protected $table = 'playground';

    
    public static function GetList() {
        return static::all();
    }
}