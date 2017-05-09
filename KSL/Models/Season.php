<?php
namespace KSL\Models;

class Season extends Base
{
    //
    // https://laravel.com/docs/5.3/eloquent
    //
    protected $table = 'season';
    
    public static function GetActual() {
        $season = Static::find(['active' => 1]);

        if($season->count() === 1) return $season->first();
        else return null;
    }


    public static function GetActualYear() {
        return date('Y');
    }
}