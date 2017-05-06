<?php
namespace KSL\Controllers;

use \KSL\Models;
use \Illuminate\Database\Connection;

class Players extends Base
{
    public function show($request, $response, $args) {
        throw new exception("TODO !!");
    }
    
    public function showPlayer($request, $response, $args) {
        $seo            = $args['seo'];
        $player         = Models\Players::where('seo', $seo)->first();
        $team           = $player->GetTeam();
       

        
        return $response->write( $this->ci->twig->render('player.tpl', [
            'player'            => $player,
            'team'              => $team,
            'navigationSwitch'  => ''
        ]));
   }

}