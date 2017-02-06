<?php
namespace KSL\Controllers;

use \KSL\Models;
use \Illuminate\Database\Connection;

class Teams extends Base
{
    public function showTeam($request, $response, $args) {
        $team           = Models\Teams::where('short', 'fun')->first();
        $teams          = $this->GetTeams();
        
        return $response->write( $this->ci->twig->render('teams.tpl', [
            'navigationSwitch'      => 'timy',
            'team'                  => $team,
            'teams'                 => $teams,
            'games'                 => $this->GetGames($team->id)
        ]));
   }
   
  private function GetTeams() {
       $teams = [];
       foreach(Models\Teams::cursor() as $team) {
            $teams[$team->id] = $team;
        }
        
        return $teams;
   }
   
   
   private function GetGames($teamId) {
       return Models\Games::where('hometeam', $teamId)->orWhere('awayTeam', $teamId)->orderBy('date', 'asc')->get();
   }
}