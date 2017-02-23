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
    
    
    
    public static function GenerateRandomPoints() {
        ScoreList::Truncate();

        $games = Games::take(3)->get();
        foreach($games as $game) {
            $home = $game->GetHomeTeam();
            $away = $game->GetAwayTeam();
            
            $homePlayers = $home->GetPlayers();
            $awayPlayers = $away->GetPlayers();
            
            for($i = 0; $i < 15; $i++) {
                $score = new ScoreList();
                $score->game_id = $game->id;
                $score->player_id = $homePlayers->Get(0)->id;
                $score->team_id = $home->id;
                $score->second = $i;
                $score->value = rand(0, 1) > 0 ? '2pt' : '3pt';
                $score->Save();
                
                $score = new ScoreList();
                $score->game_id = $game->id;
                $score->player_id = $awayPlayers->Get(0)->id;
                $score->team_id = $away->id;
                $score->second = $i;
                $score->value = rand(0, 1) > 0 ? '2pt' : '3pt';
                $score->Save();
            }
            
        }
    }
    
    
    
    
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