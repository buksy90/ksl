<?php
namespace KSL\Models;

class Roster extends Base
{
    //
    // https://laravel.com/docs/5.3/eloquent
    //
    protected $table = 'roster';
    //protected $primaryKey = 'id'; // Not necessary as this is default
    public $timestamps = false;
    
    public static function GetActualYear() {
        return date('Y');
    }
    
    public function scopeThisYear($query) {
        return $query->where('year', date('Y'));
    }
    
    public function scopeYear($query, $year) {
        return $query->where('year', (int) $year);
    }
}