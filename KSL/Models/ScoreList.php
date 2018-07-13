<?php
namespace KSL\Models;

use \Illuminate\Database\Connection;

class ScoreList extends Base
{
    //
    // https://laravel.com/docs/5.3/eloquent
    //
    protected $table = TABLE_PREFIX . 'score_list';
    //protected $primaryKey = 'id'; // Not necessary as this is default
    public $timestamps = false;
    

    public static function ClearList() {
        GameRoster::Truncate();
        ScoreList::Truncate();

        $games = Games::all();
        foreach($games as $game) {
            $game->home_score = NULL;
            $game->away_score = NULL;
            $game->won = NULL;
            $game->Save();
        }
    }
    
    
    public static function GenerateRandomPoints($gamesCount) {
        ScoreList::Truncate();

        $games = Games::take($gamesCount)->get();
        foreach($games as $game) {
            $home = $game->GetHomeTeam();
            $away = $game->GetAwayTeam();
            
            $homePlayers = $home->GetPlayers();
            $awayPlayers = $away->GetPlayers();

            $playingHomePlayers = [];
            $playingAwayPlayers = [];
            
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
                $score->value = $valueHome;
                $score->Save();

                $scoreHome += $valueHome;
                $playingHomePlayers[$score->player_id] = true;
            }


            foreach(array_keys($playingHomePlayers) as $playerId) {
                $entry = new GameRoster();
                $entry->player_id = $playerId;
                $entry->game_id = $game->id;
                $entry->Save();
            }
           
            $iterations = rand(10, 30);
            for($i = 0; $i < $iterations; $i++) {
                $valueAway = rand(0, 1) > 0 ? 2 : 3;
                $score = new ScoreList();
                $score->game_id = $game->id;
                $score->player_id = $awayPlayers->Get(rand(0, $awayPlayers->count()-1))->id;
                $score->team_id = $away->id;
                $score->second = $i;
                $score->value = $valueAway;
                $score->Save();

                $scoreAway += $valueAway;
                $playingAwayPlayers[$score->player_id] = true;
            }


            foreach(array_keys($playingAwayPlayers) as $playerId) {
                $entry = new GameRoster();
                $entry->player_id = $playerId;
                $entry->game_id = $game->id;
                $entry->Save();
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
    
    
    public function GetFromGame(Games $game, $teamSide) {
        $scoreListTable     = ScoreList::getTableName();
        $rosterTableName    = Roster::getTableName();

        $scoreList   = $this->select($this->getConnection()->raw('SUM(`'.$scoreListTable.'`.`value`) as "sum", `'.$scoreListTable.'`.`player_id`'))
        ->where('game_id', $this->getConnection()->raw('"'.$game->id.'"'))
        ->join($rosterTableName, function($join) use($game, $teamSide, $rosterTableName, $scoreListTable) {
            $join->on($rosterTableName.'.team_id', '=', $this->getConnection()->raw('"'.$teamSide.'"'));
            $join->on($rosterTableName.'.player_id', '=', $scoreListTable.'.player_id');
            $join->where($rosterTableName.'.season_id', '=', Season::GetActual()->id);
        })
        ->groupBy($scoreListTable.'.player_id')
        ->orderBy('sum', 'desc')
        ->get();
                
        return $scoreList;
    }


    public static function GetPointsOfPlayer($playerId, $season = null) {
        $instance = new Static();

        if($season === null) {
            return Static::Select($instance->getConnection()->raw('SUM(`value`) AS `sum`'))
                ->Where('player_id', $playerId)
                ->first()
                ->sum;
        }
        else throw "Not implemented";
    }
}