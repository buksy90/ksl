<?php
namespace KSL\Models;

class Season extends Base
{
    //
    // https://laravel.com/docs/5.3/eloquent
    //
    protected $table = 'season';
    
    public static function GetActual() {
        return static::where('active', '1')->first();
    }
}