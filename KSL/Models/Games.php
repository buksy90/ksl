<?php
namespace KSL\Models;

class Games extends Base
{
    //
    // https://laravel.com/docs/5.3/eloquent
    //
    protected $table = TABLE_PREFIX . 'games';
    //protected $primaryKey = 'id'; // Not necessary as this is default
    public $timestamps = false;
    
    
    public function GetHomeTeam() {
        return Teams::find($this->hometeam);
    }
    
    public function GetAwayTeam() {
        return Teams::find($this->awayteam);
    }
    
    public function scopePlayedBy($query, $teamId) {
        return $query->where('hometeam', $teamId)->orWhere('awayteam', $teamId);
    }
    
    public function scopeWonBy($query, $teamId) {
        return $query->where([['hometeam', $teamId], ['won', 'home']])->orWhere([['awayteam', $teamId], ['won', 'away']]);
    }
    
    public function scopeLostBy($query, $teamId) {
        return $query->where([['hometeam', $teamId], ['won', 'away']])->orWhere([['awayteam', $teamId], ['won', 'home']]);
    }

    public function scopeAlreadyPlayed($query) {
        return $query->whereNotNull('won');
    }

    public function scopeNotPlayedYet($query) {
        return $query->whereNull('won');
    }

    
    public static function GetNextAtPlayground($playgroundId, $limit = 5) {
        $game   = new Self();
        return static::Where('playground_id', $playgroundId)->Where('date', '>=', $game->getConnection()->raw('CURDATE()'))->take($limit)->get();
    }
    
    /**
    * Returns array of games dates
    */
    public static function GetListOfDates() {
        $game       = new Self();
        $season     = Season::GetActual();
        
        if($season instanceof Season === false) return false;
        
        $query      = static::Select($game->getConnection()->raw('CONCAT(MONTH(`date`), "/", DAY(`date`), "/", YEAR(`date`)) AS `dayDate`'))
            ->Where('season_id', $season->id)
            ->GroupBy($game->getConnection()->raw('CONCAT(MONTH(`date`), "/", DAY(`date`), "/", YEAR(`date`))'))
            ->get();

        return $query->map(function($game){
            return strtotime($game->dayDate);
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
        
        $result = static::Select($game->getConnection()->raw('CONCAT(MONTH(`date`), "/", DAY(`date`), "/", YEAR(`date`)) AS `dayDate`'))
            ->Where('season_id', $season->id)
            ->Where('date', '>=', $game->getConnection()->raw('CURDATE()'))
            ->GroupBy($game->getConnection()->raw('CONCAT(MONTH(`date`), "/", DAY(`date`), "/", YEAR(`date`))'))
            ->OrderBy('dayDate', 'asc')
            ->skip($x-1)
            ->first();

        return is_object($result)
            ? strtotime($result->dayDate)
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
            ->Where($game->getConnection()->raw('CONCAT(MONTH(`date`), "/", DAY(`date`), "/", YEAR(`date`))'), '=', $dayDate)
            ->get();
            
            return $q;
    }
}
