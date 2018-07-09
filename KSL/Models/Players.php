<?php
namespace KSL\Models;
use \Illuminate\Database\Connection;

class Players extends Base
{
    //
    // https://laravel.com/docs/5.3/eloquent
    //
    protected $table = TABLE_PREFIX . 'players';
    //protected $primaryKey = 'id'; // Not necessary as this is default
    public $timestamps = false;
    
    
    /*
    There may be some kind of Team scope that would filter players playing for certain team
    public function scopeTeam($query, $teamId) {
        return $query->where('hometeam', $teamId)->orWhere('awayTeam', $teamName);
    }
    */
    
    
    public function GetTeam() {
        $team_id = Roster::
            select($this->getConnection()->raw('`team_id`'))
            ->where('season_id', '=', $this->getConnection()->raw(Season::GetActual()->id))
            ->where('player_id', '=',  $this->getConnection()->raw($this->id))
            ->first()
            ->team_id;
            
        return Teams::find($team_id);
    }
    
    
    //
    // Generate seo for each player in database that has seo set to null
    //
    public static function GenerateSEOGlobally() {
        $players = self::get();
        
        foreach($players as $player) {
            if($player->seo != null && strlen($player->seo) > 0) continue;
            
            $player->GenerateSEO();
        }
    }
    
    
    //
    // Generate seo column for player
    // seo name is geenrated from nick (if set), otherwise from name
    //
    public function GenerateSEO() {
        $seo      = iconv('UTF-8', 'ASCII//TRANSLIT', $this->nick != null && strlen($this->nick) > 0
            ? $this->nick
            : $this->name.'_'.$this->surname);
            
        $this->seo = strtolower(str_replace(' ', '_', $seo));
        $this->save();
        
        return $seo;
    }
    
    
    
    //
    // Get count of games played by $this player this (Roster::GetActualYear) season
    //
    public function GetGamesCount() {
        $modelInstance  = new Static();
        $scoreListTable = ScoreList::getTableName();
        
        $sql = '
            SELECT 
                COUNT( * ) AS `count`
            FROM 
            (
                SELECT t1.game_id
                FROM  `'.$scoreListTable.'` t1 
                INNER JOIN  `'.Roster::getTableName().'` AS t2 ON  `t1`.`player_id` =  `t2`.`player_id` AND  `t2`.`season_id` = '.Season::GetActual()->id.'
                WHERE  `t1`.`player_id` = "'.(int)$this->id.'"
                GROUP BY  `t1`.`game_id`
            ) t
            ';
        
         $result = $modelInstance->getConnection()->select($sql)[0];
         return $result->count;
    }
    
    
    //
    // Get sum of points scored by $this player this season
    //
    // Arguments:
    // $only3pt - should only 3pts be considered? 
    //          If true, returned sum represents number of made 3pt shots, 
    //          if false [default], returned number represents number of made points (from 2pt & 3pt shots)
    // $allSeasons - should points from all seasons be considered? If false [default] only active season is considered
    public function GetPointsSum($only3pt = null, $allSeasons = null) {
        $scoreListTable     = ScoreList::getTableName();
        $rosterTableName    = Roster::getTableName();

        if($only3pt === true) {
            $query = ScoreList::select($this->getConnection()->raw('sum(`'.$scoreListTable.'`.`value`="3") as "sum"'));
            $query->where($scoreListTable.'.value', '3');
        }
        else $query = ScoreList::select($this->getConnection()->raw('sum(`'.$scoreListTable.'`.`value`) as "sum"'));
        
        $query->where($scoreListTable.'.player_id', $this->id);
                
                
        if($allSeasons !== true) {
            $query->groupBy($scoreListTable.'.player_id')
            ->join($rosterTableName, function($join) use($rosterTableName, $scoreListTable) {
                $join->on($scoreListTable.'.player_id', '=', $rosterTableName.'.player_id');
                $join->where($rosterTableName.'.season_id', '=', Season::GetActual()->id);
            });
        }
            
            
        $fetched = $query->first();
        return $fetched !== null && is_numeric($fetched->sum) ? $fetched->sum : 0;
    }
    
    
    /**
     * returns all players active specific season
     */
    public static function GetPlayersBySeason($season_id) {
        $players            = [];
        $rosterTableName    = Roster::getTableName();
        $playersTableName   = Players::getTableName();

        $playersCollection  = static::join($rosterTableName, function($join) use($season_id, $rosterTableName, $playersTableName) {
            $join->on($rosterTableName.'.player_id', '=', $playersTableName.'.id')
                 ->where($rosterTableName.'.season_id', '=', $season_id);
        })->get();
        
        foreach($playersCollection as $player) {
            $players[$player->id] = $player;
        }
        
        return $players;
   }


   public function GetRank() {
       $pointsScored        = $this->GetPointsSum(false, true);
       $scoreListTable      = ScoreList::getTableName();


       $betterPlayersSql = '
            SELECT COUNT(*) AS `count` FROM
            (
                SELECT SUM(value) as `sum` FROM '.$scoreListTable.' t1 GROUP BY player_id 
                HAVING SUM(value) > '.(int)$pointsScored.'
                ORDER BY `sum` DESC
            ) td1
            ';
        
        $betterPlayersCount = $this->getConnection()->select($betterPlayersSql)[0]->count;

        return $betterPlayersCount + 1;
   }


   public function GetOverall() {
       return 100 - $this->GetRank();
   }


    public function GetGamesPlayed($season_id = null) {
        $gameRosterTable    = GameRoster::getTableName();
        $gameTable          = Game::getTableName();

        $games = Games::join($gameRosterTable, function($join) use($gameRosterTable, $gameTable) {
                $join->on($gameTable.'.id', '=', $gameRosterTable.'.game_id');
                $join->where($gameRosterTable.'.player_id', '=', $this->id);
            });

        if(is_numeric($season_id)) $games = $games->Where('season_id', $season_id);

        return $games->get();
   }


    public function GetGamesStatistics($season_id = null) {
        $gamesTable         = Games::getTableName();
        $gameRosterTable    = GameRoster::getTableName();
        $rosterTable        = Roster::getTableName();
        $prefix             = $this->getConnection()->getTablePrefix();

        $games = Games::select($this->getConnection()->raw('
            sum(`won` = "home" AND '.$gamesTable.'.hometeam = '.$prefix.'t3.team_id)+sum(`won` = "away" AND '.$gamesTable.'.awayteam = '.$prefix.'t3.team_id) AS `won`,
            sum(`won` = "away" AND '.$gamesTable.'.hometeam = '.$prefix.'t3.team_id)+sum(`won` = "home" AND '.$gamesTable.'.awayteam = '.$prefix.'t3.team_id) AS `lost` '))
            ->join($gameRosterTable, function($join) use($gameTable, $gameRosterTable) {
                $join->on($gameTable.'.id', '=', $gameRosterTable.'.game_id');
                $join->where($gameRosterTable.'.player_id', '=', $this->id);
            })
            ->join($rosterTable, function($join) use($rosterTable, $gameTable) {
                $join->on($rosterTable.'.season_id', $gameTable.'.season_id');
                $join->where($rosterTable.'.player_id', '=', $this->id);
            });

        if(is_numeric($season_id)) $games = $games->Where('season_id', $season_id);

        return $games->first();
    }
}
