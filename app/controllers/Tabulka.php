<?php
namespace KSL\Controllers;

use \KSL\Models;
use \Illuminate\Database\Connection;

class Tabulka extends Base
{
    public function show($request, $response, $args) {
        $teams          = $this->GetTeams();
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
   // Get list of teams with their details
   //
   private function GetTeams() {
       //
       // TODO: This selects all teams, not only those playing current season
       //
       return Models\Teams::select('id', 'name')->get()->map(function(Models\Teams $team){
            $games          = Models\Games::playedBy($team->id)->count();
            $history        = $team->GetHistory();
            $won            = $history['won'];
            $lost           = $history['lost'];
            $points         = $lost + $won * 2;
            $success        = $games === 0 ? 0 : ($won / $games) * 100;
            $scoredHome     = Models\Games::select($this->ci->connection->raw('SUM(home_score) as "sum"'))->where('hometeam', $team->id)->first()->sum + 0;
            $scoredAway     = Models\Games::select($this->ci->connection->raw('SUM(away_score) as "sum"'))->where('awayteam', $team->id)->first()->sum + 0;
            $scored         = $scoredHome + $scoredAway;
            $receivedHome   = Models\Games::select($this->ci->connection->raw('SUM(away_score) as "sum"'))->where('hometeam', $team->id)->first()->sum + 0;
            $receivedAway   = Models\Games::select($this->ci->connection->raw('SUM(home_score) as "sum"'))->where('awayteam', $team->id)->first()->sum + 0;
            $received       = $receivedHome + $receivedAway;
            
            return [
                'teamObj'       => $team,
                'games'         => $games,
                'won'           => $won,
                'lost'          => $lost,
                'points'        => $points,
                'success'       => $success,
                'scored'        => $scored,
                'received'      => $received
            ];
        });
   }



    //
    // Get list of shooters with statistics
    //
    // Args:
    // $only3pt - (bool) whether to count only 3pts made
    private function GetShooters($only3pt = null) {
        $shooters = Models\Players::join('roster', function($join){
            $join->on('players.id', '=', 'roster.player_id');
            $join->on('roster.year', '=', $this->ci->connection->raw('"'.date('Y').'"'));
        })->get()->map(function($player) use($only3pt) {
            $team       = Models\Teams::first($player->attributes['team_id']);
            $games      = $player->GetGamesCount();
            $points     = $player->GetPointsSum($only3pt);
    
            return [
                'playerObj'         => $player,
                'team'              => $team->name,
                'games'             => $games,
                'points'            => $points,
                'avg'               => $games > 0 ? $points / $games : 0
            ];
        })->toArray();
        
        usort($shooters, function($a, $b){
            return $b['avg'] - $a['avg'];
        });
        
        return $shooters;
    }
    
    
}