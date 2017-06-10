<?php
namespace KSL\Controllers;

use \KSL\Models;
use \Illuminate\Database\Connection;

class Tabulka extends Base
{
    public function show($request, $response, $args) {
        $teams          = Models\Teams::GetStandings();
        $shooters       = $this->GetShooters();
        $shooters3pt    = $this->GetShooters(true);
        
        
        return $response->write( $this->ci->twig->render('tabulka.tpl', [
            'navigationSwitch'      => 'tabulka',
            'teams'                 => $teams,
            'shooters'              => $shooters,
            'shooters3pt'           => $shooters3pt
        ]));
   }
   
   

    //
    // Get list of shooters with statistics
    //
    // Args:
    // $only3pt - (bool) whether to count only 3pts made
    //
    //
    //  TODO : ONLY PLAYERS THAT HAS PLAYED MORE THAN 50% OF TEAM GAMES SHOULD BE RETURNED
    //
    //
    private function GetShooters($only3pt = null) {
        $season     = Models\Season::GetActual();
        if($season instanceof Models\Season === false) return false;
        
        $teamsCollection    = Models\Teams::orderBy('id', 'ASC')->get();
        $teams              = [ ];
        foreach($teamsCollection as $team) {
            $teams[$team->id] = $team;
        }
        
        
        $shooters = Models\Players::join('roster', function($join) use($season) {
            $join->on('players.id', '=', 'roster.player_id');
            $join->where('roster.season_id', '=', $season->id);
        })->get()->map(function($player) use($only3pt, $teams) {
            $team       = $teams[$player->team_id];
            $games      = $player->GetGamesCount();
            $points     = $player->GetPointsSum($only3pt);
    
            return [
                'playerObj'         => $player,
                'team'              => $team,
                'games'             => $games,
                'points'            => $points,
                'avg'               => $games > 0 ? round($points / $games, 2) : 0
            ];
        })->toArray();
        
        usort($shooters, function($a, $b){
            return $b['avg']*100 - $a['avg']*100;
        });
        
        return $shooters;
    }
    
    
}