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
        $seo                = $args['seo'];
        $player             = Models\Players::where('seo', $seo)->first();
        $team               = $player->GetTeam();
        $gamesPlayedCount   = Models\GameRoster::GetPlayerGamesCount($player->id);
        $playerRank         = $player->GetRank();
        $playerOverall      = $player->GetOverall();
        $images             = [
            'http://www.clipartkid.com/images/85/basketball-silhouette-clipart-best-6R6uFT-clipart.jpeg',
            'http://www.clipartkid.com/images/85/clipartbest-com-0qUsrS-clipart.jpeg',
            'http://m.rgbimg.com/cache1nGjdA/users/h/hi/hisks/600/mhYpYCG.jpg',
            'http://www.clipartbest.com/cliparts/4T9/6RK/4T96RKgXc.jpg'
        ];

                
        return $response->write( $this->ci->twig->render('player.tpl', [
            'player'            => $player,
            'team'              => $team,
            'gamesPlayedCount'  => $gamesPlayedCount,
            'gamesWonCount'     => 'X',
            'gamesLostCount'    => 'X',
            'gamesSuccessRate'  => 'X',
            'playerRank'        => $playerRank,
            'playerOverall'     => $playerOverall,
            'scoredPoints'      => $player->GetPointsSum(false, true),
            'threePointsMade'   => $player->GetPointsSum(true, true),
            'image'             => $images[rand(0, count($images)-1)],
            'navigationSwitch'  => ''
        ]));
   }

}