<?php
namespace KSL\Models;

class GameRoster extends Base
{
    protected $table = 'game_roster';
    public $timestamps = false;


    public static function GetPlayerGames($player_id) {
        $gameRoster = new Static();
        
        return Self::Select($gameRoster->getConnection()->raw('COUNT("*") AS `count`'))
            ->where('player_id', $player_id)
            ->first()
            ->count;
    }
}
