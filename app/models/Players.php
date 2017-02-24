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
          $tmp =  ScoreList::select($this->getConnection()->raw('count(DISTINCT `score_list`.`player_id`) as count'))
                ->where('score_list.player_id', $this->getConnection()->raw('"'.$this->id.'"'))
                ->groupBy('game_id')
                ->groupBy('roster.player_id')
                ->join('roster', function($join){
                    $join->on('score_list.player_id', '=', 'roster.player_id');
                    $join->where('roster.season_id', '=', Season::GetActual()->id);
                })->first();
                
                return ($tmp !== null) ? $tmp->count : 0;
    }
    
    
    //
    // Get sum of points scored by $this player this season
    //
    // Arguments:
    // $only3pt - should only 3pts be considered? 
    //          If true, returned sum represents number of made 3pt shots, 
    //          if false [default], returned number represents number of made points (from 2pt & 3pt shots)
    // $allSeasons - should points from all seasons be considered? If false [default] only active season is considered
    public function GetPointsSum($only3pt = null, $allSeasons = null) {
        
        if($only3pt === true) {
            $query = ScoreList::select($this->getConnection()->raw('sum(`score_list`.`value`="3pt") as "sum"'));
            $query->where('score_list.value', '3pt');
        }
        else $query = ScoreList::select($this->getConnection()->raw('sum(`score_list`.`value`="2pt")*2 + sum(`score_list`.`value`="3pt")*3 as "sum"'));
        
        $query->where('score_list'.'.player_id', $this->id);
                
                
        if($allSeasons !== true) {
            $query->groupBy('score_list.player_id')
            ->join('roster', function($join){
                $join->on('score_list.player_id', '=', 'roster.player_id');
                $join->where('roster.season_id', '=', Season::GetActual()->id);
            });
        }
            
            
        $fetched = $query->first();
        return $fetched !== null ? $fetched->sum : 0;
    }
    
    
    /**
     * returns all players active specific season
     */
    public static function GetPlayersBySeason($season_id) {
        $players            = [];
        $playersCollection  = static::join('roster', function($join) use($season_id) {
            $join->on('roster.player_id', '=', 'players.id')
                 ->where('roster.season_id', '=', $season_id);
        })->get();
        
        foreach($playersCollection as $player) {
            $players[$player->id] = $player;
        }
        
        return $players;
   }
}
