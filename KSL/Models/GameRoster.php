<?php
namespace KSL\Models;

class GameRoster extends Base
{
    protected $table = TABLE_PREFIX . 'game_roster';
    public $timestamps = false;


    public static function GetPlayerGamesCount($player_id) {
        $gameRoster = new Static();
        
        return Self::Select($gameRoster->getConnection()->raw('COUNT("*") AS `count`'))
            ->where('player_id', $player_id)
            ->first()
            ->count;
    }
}
