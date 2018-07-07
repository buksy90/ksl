<?php
namespace KSL\Models;

class Season extends Base
{
    //
    // https://laravel.com/docs/5.3/eloquent
    //
    protected $table = TABLE_PREFIX . 'season';
    
    public static function GetActual() {
        $season = Static::where(['active' => 1]);
        
        if($season->count() === 1) return $season->first();
        else throw new \Exception('Unknown active season');
    }


    public static function GetActualYear() {
        return date('Y');
    }
}