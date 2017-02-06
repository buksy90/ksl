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
    
    
    
    public function scopePlayedBy($query, $teamId) {
        return $query->where('hometeam', $teamId)->orWhere('awayTeam', $teamId);
    }
    
    public function scopeWonBy($query, $teamId) {
        return $query->where([['hometeam', $teamId], ['won', 'home']])->orWhere([['awayTeam', $teamId], ['won', 'away']]);
    }
    
    public function scopeLostBy($query, $teamId) {
        return $query->where([['hometeam', $teamId], ['won', 'away']])->orWhere([['awayTeam', $teamId], ['won', 'home']]);
    }
    
    
    public static function GetNextAtPlayground($playgroundId, $limit = 5) {
        return static::Where('playground_id', $playgroundId)->Where('date', '>=', time())->take($limit)->get();
    }
    
    public static function GetListOfDates() {
        $game       = new Self();
        $season     = Season::GetActual();
        $query      = static::Select($game->getConnection()->raw('UNIX_TIMESTAMP(DATE(FROM_UNIXTIME(`date`))) AS `dayDate`'))
            ->Where('season_id', $season->id)
            ->GroupBy($game->getConnection()->raw('DATE(FROM_UNIXTIME(`date`))'))
            ->get();
        
        return $query->map(function($game){
            return $game->dayDate;
        });
    }
    
    /**
     * Get next when any match will be plated 
    */
    public static function GetNextDayDate() {
        $game       = new Self();
        $season     = Season::GetActual();
        return static::Select($game->getConnection()->raw('UNIX_TIMESTAMP(DATE(FROM_UNIXTIME(`date`))) AS `dayDate`'))
            ->Where('season_id', $season->id)
            ->Where('date', '>=', time())
            ->GroupBy($game->getConnection()->raw('DATE(FROM_UNIXTIME(`date`))'))
            ->OrderBy('dayDate', 'asc')
            ->first()
            ->dayDate;
    }
    
    /**
     * Returns games that are going to be played next
     */
    public static function GetNextGames() {
        $game       = new Self();
        $season     = Season::GetActual();
        $dayDate    = static::GetNextDayDate();
        $q =  static::Where('season_id', $season->id)
            ->Where($game->getConnection()->raw('UNIX_TIMESTAMP(DATE(FROM_UNIXTIME(`date`)))'), '=', $dayDate)
            ->get();
            
            return $q;
    }
}
