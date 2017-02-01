<?php
namespace KSL\Models;

use \Illuminate\Database\Connection;

class ScoreList extends Base
{
    //
    // https://laravel.com/docs/5.3/eloquent
    //
    protected $table = 'score_list';
    //protected $primaryKey = 'id'; // Not necessary as this is default
    public $timestamps = false;
    
    
    
    
    
    //
    // Get scoreList of players that played in a game
    //
    // $game - (Models\Game) instance of game
    // $side - (sting) side of players (home / away)
    //
    // Returns: array of players ids and number of points they scored
    public static function GetFromGameStatic(Games $game, $side) {
        $list       = new self();
        return $list->GetFromGame($game, $side);
    }
    
    
    public function GetFromGame(Games $game, $side) {
        $teamSide    = $side . 'team';
        
        $scoreList   = $this->select($this->getConnection()->raw('SUM(`score_list`.`value`) as "sum", `score_list`.`player_id`'))
        ->where('game_id', $this->getConnection()->raw('"'.$game->id.'"'))
        ->join('roster', function($join) use($game, $teamSide) {
            $join->on('roster.team_id', '=', $this->getConnection()->raw('"'.$teamSide.'"'));
            $join->on('roster.player_id', '=', 'score_list.player_id');
            $join->where('roster.season_id', '=', Season::GetActual()->id);
        })
        ->groupBy('score_list.player_id')
        ->orderBy('sum', 'desc')
        ->get();
                
        return $scoreList;
    }
}