<?php
namespace KSL\Models;

class Roster extends Base
{
    //
    // https://laravel.com/docs/5.3/eloquent
    //
    protected $table = TABLE_PREFIX . 'roster';
    //protected $primaryKey = 'id'; // Not necessary as this is default
    public $timestamps = false;
        

    public function scopeThisYear($query) {
        throw new \Exception("deprecated scopeThisYear() called");
        return $query->where('year', date('Y'));
    }
    
    public function scopeYear($query, $year) {
        throw new \Exception("deprecated scopeYear() called");
        return $query->where('year', (int) $year);
    }
}