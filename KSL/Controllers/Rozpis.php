<?php
namespace KSL\Controllers;

use \KSL\Models;
use \Illuminate\Database\Connection;

class Rozpis extends Base
{
    public function show($request, $response, $args) {
        $season     = Models\Season::GetActual();
        $teams      = Models\Teams::GetTeamsIndexedArray();
        $dates      = Models\Games::GetListOfDates();
        $nextDate   = null;
        $players    = ($season instanceof Models\Season) ? Models\Players::GetPlayersBySeason($season->id) : false;
        
        // Get next game time
        if($dates !== false) foreach($dates as $date) {
            if($date >= time()) {
                $nextDate = $date;
                break;
            }
        }
        
        $games = Models\Games::all()->map(function($game) use($teams) {
            $homeScoreList = Models\ScoreList::GetFromGameStatic($game, 'home');
            $awayScoreList = Models\ScoreList::GetFromGameStatic($game, 'away');
            $dateTimestamp = strtotime($game->date);
    
            return [
                'gameObj'       => $game,
                'homeScoreList' => $homeScoreList,
                'awayScoreList' => $awayScoreList,
                'dayDate'       => mktime(0,0,0, date('m', $dateTimestamp), date('j', $dateTimestamp), date('Y', $dateTimestamp)),
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
            'season'            => $season,
            'dates'             => $dates,
            'nextDate'          => $nextDate
        ]));
   }
}