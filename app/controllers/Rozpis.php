<?php
namespace KSL\Controllers;

use \KSL\Models;
use \Illuminate\Database\Connection;

class Rozpis extends Base
{
    public function show($request, $response, $args) {
        $teams      = $this->GetTeams();
        $players    = $this->GetPlayers();
        
        $games = Models\Games::all()->map(function($game) use($teams) {
            $homeScoreList = $this->GetScoreList($game, 'home');
            $awayScoreList = $this->GetScoreList($game, 'away');
    
            return [
                'gameObj'       => $game,
                'homeScoreList' => $homeScoreList,
                'awayScoreList' => $awayScoreList,
                'homeTeam'      => $teams[$game->hometeam],
                'awayTeam'      => $teams[$game->awayteam],
                'homeHistory'   => $teams[$game->hometeam]->GetHistory(),
                'awayHistory'   => $teams[$game->awayteam]->GetHistory(),
            ];
        });
        
        return $response->write( $this->ci->twig->render('rozpis.tpl', [
            'navigationSwitch'  => 'rozpis',
            'games'             => $games,
            'players'           => $players,
        ]));
   }
   
   
   
   
   private function GetTeams() {
       $teams = [];
       foreach(Models\Teams::cursor() as $team) {
            $teams[$team->id] = $team;
        }
        
        return $teams;
   }
   
   // returns all players active this season
   private function GetPlayers() {
        $players            = [];
        $playersCollection  = Models\Players::join('roster', function($join){
            $join->on('roster.player_id', '=', 'players.id')
                 ->where('roster.year', '=', Models\Roster::GetActualYear());
        })->get();
        
        foreach($playersCollection as $player) {
            $players[$player->id] = $player;
        }
        
        return $players;
   }
   
   
   //
   // Get scoreList of players that played in a game
   //
   // $game - (Models\Game) instance of game
   // $side - (sting) side of players (home / away)
   //
   // Returns: array of players ids and number of points they scored
   private function GetScoreList(Models\Games $game, $side) {
       $teamSide    = $side . 'team';
       
       $scoreList   = Models\ScoreList::select(Connection::raw('SUM(`score_list`.`value`) as "sum", `score_list`.`player_id`'))
        ->where('game_id', Connection::raw('"'.$game->id.'"'))
        ->join('roster', function($join) use($game) {
            $join->on('roster.team_id', '=', Connection::raw('"'.$teamSide.'"'));
            $join->on('roster.year', '=', Connection::raw('"'.Models\Roster::GetActualYear().'"'));
            $join->on('roster.player_id', '=', 'score_list.player_id');
        })
        ->groupBy('score_list.player_id')
        ->orderBy('sum', 'desc')
        ->get();
                
        return $scoreList;
   }
}