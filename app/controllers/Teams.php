<?php
namespace KSL\Controllers;

use \KSL\Models;
use \Illuminate\Database\Connection;

class Teams extends Base
{
    public function show($request, $response, $args) {
        throw new exception("TODO !!");
    }
    
    public function showTeam($request, $response, $args) {
        $teamShort      = $args['short'];
        $team           = Models\Teams::where('short', $teamShort)->first();
        $teams          = Models\Teams::GetTeamsIndexedArray();
        
        return $response->write( $this->ci->twig->render('teams.tpl', [
            'navigationSwitch'      => 'timy',
            'team'                  => $team,
            'teams'                 => $teams,
            'games'                 => $this->GetGames($team->id)
        ]));
   }
   

   
   
   private function GetGames($teamId) {
       return Models\Games::where('hometeam', $teamId)->orWhere('awayTeam', $teamId)->orderBy('date', 'asc')->get();
   }
}