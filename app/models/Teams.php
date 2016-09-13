<?php
namespace KSL\Models;

class Teams extends Base
{
    //
    // https://laravel.com/docs/5.3/eloquent
    //
    protected $table = 'teams';
    //protected $primaryKey = 'id'; // Not necessary as this is default
    public $timestamps = false;
    
    private $history = null;
    
    public function GetHistory() {
        if($this->history === null) {
            $this->history =  [
                'won'   => Games::wonBy($this->id)->count(),
                'lost'  => Games::lostBy($this->id)->count()
            ];
        }
        
        return $this->history;
    }
    
    
    public static function GetList() {
        return static::all();
    }
}