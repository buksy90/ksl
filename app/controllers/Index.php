<?php
namespace KSL\Controllers;

use \KSL\Models;
use \Illuminate\Database\Connection;

class Index extends Base
{
    public function show($request, $response, $args) {
        $season     = Models\Season::GetActual();
        $teams      = $this->GetTeams();
        
        $games = Models\Games::GetNextGames()->map(function($game) use($teams) {
            $homeScoreList = Models\ScoreList::GetFromGameStatic($game, 'home');
            $awayScoreList = Models\ScoreList::GetFromGameStatic($game, 'away');
    
            return [
                'gameObj'       => $game,
                'homeScoreList' => $homeScoreList,
                'awayScoreList' => $awayScoreList,
                'dayDate'       => mktime(0,0,0, date('m', $game->date), date('j', $game->date), date('Y', $game->date)),
                'homeTeam'      => $teams[$game->hometeam],
                'awayTeam'      => $teams[$game->awayteam],
                'homeHistory'   => $teams[$game->hometeam]->GetHistory(),
                'awayHistory'   => $teams[$game->awayteam]->GetHistory(),
            ];
        });
        
        return $response->write( $this->ci->twig->render('index.tpl', [
            'navigationSwitch'  => '',
            'games'             => $games,
            'players'           => $this->GetPlayers($season->id),
            'season'            => $season,
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
   private function GetPlayers($season_id) {
        $players            = [];
        $playersCollection  = Models\Players::join('roster', function($join) use($season_id) {
            $join->on('roster.player_id', '=', 'players.id')
                 ->where('roster.season_id', '=', $season_id);
        })->get();
        
        foreach($playersCollection as $player) {
            $players[$player->id] = $player;
        }
        
        return $players;
   }
}