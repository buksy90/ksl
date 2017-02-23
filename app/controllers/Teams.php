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
        $games          = $team->GetGames();
        $playedGames    = $games->filter(function(Models\Games $game){
            return $game->won != null;
        });
        $wonGames       = $games->filter(function(Models\Games $game) use($team) {
            return ($game->won === 'home' && $game->hometeam === $team->id) || ($game->won === 'away' && $game->awayteam === $team->id);
        });
        $lostGames       = $games->filter(function(Models\Games $game) use($team) {
            return ($game->won === 'away' && $game->hometeam === $team->id) || ($game->won === 'home' && $game->awayteam === $team->id);
        });
        
        $scoredPoints   = $games->map(function(Models\Games $game) use($team) {
            return $game->hometeam === $team->id
                ? (int) $game->home_score
                : (int) $game->away_score;
        })->toArray();
        
        $allowedPoints   = $games->map(function(Models\Games $game) use($team) {
            return $game->hometeam !== $team->id
                ? (int) $game->home_score
                : (int) $game->away_score;
        })->toArray();

        
        return $response->write( $this->ci->twig->render('teams.tpl', [
            'navigationSwitch'      => 'timy',
            'team'                  => $team,
            'teams'                 => $teams,
            'players'               => $team->GetPlayers(),
            'games'                 => $games,
            'playedGamesCount'      => $playedGames->count(),
            'wonGamesCount'         => $wonGames->count(),
            'lostGamesCount'        => $lostGames->count(),
            'tiedGamesCount'        => $playedGames->count() - ( $wonGames->count() + $lostGames->count()),
            'standing'              => $team->GetStanding(),
            'scoredPoints'          => array_sum($scoredPoints),
            'scoredPointsAvg'       => $playedGames->count() > 0 ? array_sum($scoredPoints) / $playedGames->count() : 0,
            'allowedPoints'         => array_sum($allowedPoints),
            'allowedPointsAvg'      => $playedGames->count() > 0 ? array_sum($allowedPoints) / $playedGames->count() : 0,
            'successRate'           => $wonGames->count() > 0 ? round(($playedGames->count() / $wonGames->count()) * 10) : 0,
        ]));
   }
   

   
   
   private function GetGames($teamId) {
       return Models\Games::where('hometeam', $teamId)->orWhere('awayTeam', $teamId)->orderBy('date', 'asc')->get();
   }
}