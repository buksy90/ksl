<?php
namespace KSL\Models;

class Games extends Base
{
    //
    // https://laravel.com/docs/5.3/eloquent
    //
    protected $table = 'games';
    //protected $primaryKey = 'id'; // Not necessary as this is default
    public $timestamps = false;
    
    
    public function GetHomeTeam() {
        return Teams::find($this->hometeam);
    }
    
    public function GetAwayTeam() {
        return Teams::find($this->awayteam);
    }
    
    /*
    public function scopePlayedBy($query, $teamId) {
        return $query->where('hometeam', $teamId)->orWhere('awayTeam', $teamId);
    }
    */
    
    public function scopeWonBy($query, $teamId) {
        return $query->where([['hometeam', $teamId], ['won', 'home']])->orWhere([['awayTeam', $teamId], ['won', 'away']]);
    }
    
    public function scopeLostBy($query, $teamId) {
        return $query->where([['hometeam', $teamId], ['won', 'away']])->orWhere([['awayTeam', $teamId], ['won', 'home']]);
    }
    
    
    public static function GetNextAtPlayground($playgroundId, $limit = 5) {
        return static::Where('playground_id', $playgroundId)->Where('date', '>=', time())->take($limit)->get();
    }
    
    /**
    * Returns array of games dates
    */
    public static function GetListOfDates() {
        $game       = new Self();
        $season     = Season::GetActual();
        
        if($season instanceof Season === false) return false;
        
        $query      = static::Select($game->getConnection()->raw('UNIX_TIMESTAMP(DATE(FROM_UNIXTIME(`date`))) AS `dayDate`'))
            ->Where('season_id', $season->id)
            ->GroupBy($game->getConnection()->raw('DATE(FROM_UNIXTIME(`date`))'))
            ->get();
        
        return $query->map(function($game){
            return $game->dayDate;
        });
    }
    
    /**
     * Get next date when any match will be played
     * @return int
    */
    public static function GetNextDayDate() {
        return static::GetNextXDayDate(0);
    }
    
    
    /**
     * Get next playing date after next X playing dates
     * @return int
     */
    public static function GetNextXDayDate($x) {
        $game       = new Self();
        $season     = Season::GetActual();
        
        if($season instanceof Season === false) return false;
        
        $result = static::Select($game->getConnection()->raw('UNIX_TIMESTAMP(DATE(FROM_UNIXTIME(`date`))) AS `dayDate`'))
            ->Where('season_id', $season->id)
            ->Where('date', '>=', time())
            ->GroupBy($game->getConnection()->raw('DATE(FROM_UNIXTIME(`date`))'))
            ->OrderBy('dayDate', 'asc')
            ->skip($x-1)
            ->first();

        return is_object($result)
            ? $result->dayDate
            : null;
    }
    
    
    
    /**
     * Returns games that are going to be played next
     */
    public static function GetNextGames() {
        $game       = new Self();
        $dayDate    = static::GetNextDayDate();
        $season     = Season::GetActual();
        
        if($season instanceof Season === false) return false;
        
        $q =  static::Where('season_id', $season->id)
            ->Where($game->getConnection()->raw('UNIX_TIMESTAMP(DATE(FROM_UNIXTIME(`date`)))'), '=', $dayDate)
            ->get();
            
            return $q;
    }
}
