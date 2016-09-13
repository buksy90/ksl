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
            $homeScoreList = Models\ScoreList::GetFromGameStatic($game, 'home');
            $awayScoreList = Models\ScoreList::GetFromGameStatic($game, 'away');
    
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
}