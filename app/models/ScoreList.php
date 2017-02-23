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
            
            $scoreHome = 0;
            $scoreAway = 0;
            
            $iterations = rand(10, 30);
            for($i = 0; $i < $iterations; $i++) {
                $valueHome = rand(0, 1) > 0 ? 2 : 3;
                $score = new ScoreList();
                $score->game_id = $game->id;
                $score->player_id = $homePlayers->Get(rand(0, $homePlayers->count()-1))->id;
                $score->team_id = $home->id;
                $score->second = $i;
                $score->value = $valueHome . 'pt';
                $score->Save();
                $scoreHome += $valueHome;
            }
            
            $iterations = rand(10, 30);
            for($i = 0; $i < $iterations; $i++) {
                $valueAway = rand(0, 1) > 0 ? 2 : 3;
                $score = new ScoreList();
                $score->game_id = $game->id;
                $score->player_id = $awayPlayers->Get(rand(0, $awayPlayers->count()-1))->id;
                $score->team_id = $away->id;
                $score->second = $i;
                $score->value = $valueAway . 'pt';
                $score->Save();
                $scoreAway += $valueAway;
            }
            
            $game->home_score = $scoreHome;
            $game->away_score = $scoreAway;
            $game->won = $scoreHome == $scoreAway 
                ? 'tie'
                : (($scoreHome > $scoreAway) ? 'home' : 'away');
            $game->Save();
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