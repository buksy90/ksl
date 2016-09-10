<?php
namespace KSL\Models;
use \Illuminate\Database\Connection;

class Players extends Base
{
    //
    // https://laravel.com/docs/5.3/eloquent
    //
    protected $table = 'players';
    //protected $primaryKey = 'id'; // Not necessary as this is default
    public $timestamps = false;
    
    
    /*
    There may be some kind of Team scope that would filter players playing for certain team
    public function scopeTeam($query, $teamId) {
        return $query->where('hometeam', $teamId)->orWhere('awayTeam', $teamName);
    }
    */
    
    
    
    //
    // Get count of games played by $this player this (Roster::GetActualYear) season
    //
    public function GetGamesCount() {
          $tmp =  ScoreList::select(static::$_connection->raw('count(DISTINCT `score_list`.`player_id`) as count'))
                ->where('score_list.player_id', static::$_connection->raw('"'.$this->id.'"'))
                ->groupBy('game_id')
                ->groupBy('roster.player_id')
                ->join('roster', function($join){
                    $join->on('score_list.player_id', '=', 'roster.player_id');
                    $join->on('roster.year', '=', static::$_connection->raw(Roster::GetActualYear()));
                })->first();
                
                return ($tmp !== null) ? $tmp->count : 0;
    }
    
    
    //
    // Get sum of points scored by $this player this season
    //
    public function GetPointsSum($only3pt = null) {
        
        $query =  ScoreList::select(static::$_connection->raw('sum(`score_list`.`value`) as "sum"'))
                ->where('score_list'.'.player_id', static::$_connection->raw('"'.$this->id.'"'));
                
        if($only3pt === true) $query->where('score_list.value', static::$_connection->raw('"3"'));
                
                
        $query->groupBy('game_id')
            ->groupBy('roster.player_id')
            ->join('roster', function($join){
                $join->on('score_list.player_id', '=', 'roster.player_id');
                $join->on('roster.year', '=', static::$_connection->raw(Roster::GetActualYear()));
            });
            
        $tmp = $query->first();
        
        return $tmp !== null ? $tmp->sum : 0;
    }
}
