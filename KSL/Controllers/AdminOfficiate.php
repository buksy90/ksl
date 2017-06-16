<?php
namespace KSL\Controllers;

use \KSL\Models;
use \Illuminate\Database\Connection;

class AdminOfficiate extends BaseAdmin
{
    public function showGame($request, $response, $args) {
        $game          = null;

       if(array_key_exists('id', $args)) {
            $game     = Models\Games::find($args['id']);
        }

        if($game instanceof Models\Games && $game->id > 0) {
            $hometeam       = Models\Teams::find($game->hometeam);
            $awayteam       = Models\Teams::find($game->awayteam);
            $homeroster     = $hometeam->getPlayers();
            $awayroster     = $awayteam->getPlayers();

            return $response->write( $this->ci->twig->render('adminOfficiate.tpl', [
                'navigationSwitch'      => 'user',
                'game'                  => $game,
                'hometeam'              => $hometeam,
                'awayteam'              => $awayteam,
                'homeroster'            => $homeroster,
                'awayroster'            => $awayroster
            ]));
        }
        else return $this->ci['notFoundHandler']($request, $response, $args);
   }


   public function showList($request, $response, $args) {
        $games      = Models\Games::all();

        return $response->write( $this->ci->twig->render('adminOfficiate_list.tpl', [
                'navigationSwitch'      => 'user',
                'games'                  => $games
        ]));
   }
}