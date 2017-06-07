<?php
namespace KSL\Controllers;

use \KSL\Models;
use \Illuminate\Database\Connection;

class Teams extends Base
{
    public function show($request, $response, $args) {
        $path   = $this->ci->router->pathFor('tabulka');
        return $response->withHeader('Location', $path);
    }

    public function showNew($request, $response, $args) {
        $user       = \KSL\Models\User::GetUser();
        $user_id    = $user ? $user->id : null;
        $registered = Models\PendingTeams::where('user_id', $user_id)->first();

        if(Models\User::isLoggedIn() === false) {
            die('Nemáte oprávnenie na prístup k nasledujúcej stránke.');
        }

        return $response->write( $this->ci->twig->render('new_team.tpl', [
            'navigationSwitch'      => 'user',
            'registered'            => $registered
        ]));
    }

    public function showRegister($request, $response, $args) {
        if(Models\User::isLoggedIn() === false) die('Nemáte oprávnenie na prístup k tejto stránke');

        $parameters     = $request->getParsedBody();
        $user           = \KSL\Models\User::GetUser();
        $user_id        = $user ? $user->id : null;
        $registeredCount = Models\PendingTeams::where('user_id', $user_id)->count();

        if($registeredCount > 0) die('Už máte zaregistrovaný tím, ktorý čaká na schválenie.');

        $team               = new Models\PendingTeams();
        $team->name         = $parameters['name'];
        $team->short        = $parameters['short'];
        $team->user_id      = $user_id;
        
         if($team->save()) {
            $path   = $this->ci->router->pathFor('tabulka');
            return $response->withHeader('Location', $path);
        }
        else die('Vyskytla sa chyba, nepodarilo sa zaregistrovať tím');
    }


    public function showCancelRegister($request, $response, $args) {
        $parameters     = $request->getParsedBody();
        $user           = \KSL\Models\User::GetUser();
        $user_id        = $user ? $user->id : null;

        $team               = Models\PendingTeams::where('user_id', $user_id)->first();
        
         if($team->delete()) {
            $path   = $this->ci->router->pathFor('team#register');
            return $response->withHeader('Location', $path);
        }
        die('Vyskytla sa chyba, nepodarilo sa odstrániť tím z registrácie');
    }

    
    public function showTeam($request, $response, $args) {
        $teamShort      = $args['short'];
        $team           = Models\Teams::where('short', $teamShort)->first();

        if($team === null) {
            $notFoundHandler = $this->ci->get('notFoundHandler');
            return $notFoundHandler($request, $response);
        }

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
        
        
        $standings = Models\Teams::GetStandings();
        for($standing = 1; $standing <= count($standings); $standing++) {
            if($standings[$standing-1]->id == $team->id) break;
        }

        
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
            'standing'              => $standing,
            'scoredPoints'          => array_sum($scoredPoints),
            'scoredPointsAvg'       => $playedGames->count() > 0 ? array_sum($scoredPoints) / $playedGames->count() : 0,
            'allowedPoints'         => array_sum($allowedPoints),
            'allowedPointsAvg'      => $playedGames->count() > 0 ? array_sum($allowedPoints) / $playedGames->count() : 0,
            'successRate'           => $wonGames->count() > 0 ? round(($wonGames->count()/$playedGames->count()) * 100) : 0,
            'pointsAlt'             => 'Počet strelených bodov',
            'points3ptAlt'          => 'Počet premenených trojkových pokusov'
        ]));
   }

   
   
   private function GetGames($teamId) {
       return Models\Games::where('hometeam', $teamId)->orWhere('awayTeam', $teamId)->orderBy('date', 'asc')->get();
   }
}