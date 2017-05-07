<?php
namespace KSL\Controllers;

use \KSL\Models;
use \Illuminate\Database\Connection;

class Ihrisko extends Base
{
    public function showList($request, $response, $args) {
        $playgrounds          = Models\Playground::GetList();
        
        return $response->write( $this->ci->twig->render('ihriska_list.tpl', [
            'navigationSwitch'      => 'ihrisko',
            'playgrounds'           => $playgrounds,
        ]));
   }
   
   
   public function showPlayground($request, $response, $args) {
        if(array_key_exists('link', $args)) {
            $playground         = Models\Playground::where('link', $args['link'])->first();
        }
        else return $this->ci['notFoundHandler']($request, $response, $args);
  

        $games      = Models\Games::GetNextAtPlayground($playground->id)->map(function($game){
            return [
                'date'          => $game['date'],
                'homeTeam'      => Models\Teams::select('name', 'short')->Where('id', $game['hometeam'])->first(),
                'awayTeam'      => Models\Teams::select('name', 'short')->Where('id', $game['awayteam'])->first()
            ];
        });

        
        return $response->write( $this->ci->twig->render('ihrisko.tpl', [
            'navigationSwitch'      => 'ihrisko',
            'playground'            => $playground,
            'games'                 => $games
        ]));
   }
    
    
}