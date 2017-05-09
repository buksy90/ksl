<?php
namespace KSL\Controllers;

use \KSL\Models;
use \Illuminate\Database\Connection;

class Index extends Base
{
    public function show($request, $response, $args) {
        //Models\ScoreList::ClearList();
        //Models\ScoreList::GenerateRandomPoints(8);

        // This is here only for debug purposes
        // Remove in production !!
        $weatherModel = new Models\Weather();
        //$weather->UpdateDB();
        $nextDays   = [
            Models\Games::GetNextXDayDate(0),
            Models\Games::GetNextXDayDate(1),
            time(),
            strtotime('+1 day')
        ];
        $weather    = array_map(function($timestamp) use($weatherModel) {
            return $weatherModel->GetWeatherForDate($timestamp);
        }, $nextDays);

        $weather    = array_filter($weather, function($item){ return is_array($item) && count($item); });
        
        
        $season     = Models\Season::GetActual();
        $teams      = $this->GetTeams();
        $players    = $season instanceof Models\Season ? $this->GetPlayers($season->id) : null;
        
        $games      = Models\Games::GetNextGames();
        $games      = $games === false 
                ? null 
                : $games->map(function($game) use($teams) {
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
            'players'           => $players,
            'season'            => $season,
            'weather'           => array_values($weather)
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