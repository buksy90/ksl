<?php
namespace KSL\Models;

class Teams extends Base
{
    //
    // https://laravel.com/docs/5.3/eloquent
    //
    protected $table = 'teams';
    //protected $primaryKey = 'id'; // Not necessary as this is default
    public $timestamps = false;
    
    private $history = null;
    
    
    public function GetCaptain() {
        return Players::find($this->captain_id);
    }
    
    // Get standing of current team (instance)
    public function GetStanding() {
        return static::GetStandings($this->id, $this);
    }
    
    // Get standings of all teams
    public static function GetStandings($teamId = null, $modelInstance = null) {
        if($modelInstance === null) $modelInstance = new Static();
        
        $sql  = [
        '
            SELECT 
              t1.*,
              count(t2.id) as `played_games`,
              sum(t2.won="home" and t2.hometeam=t1.id) as `won_home`,
              sum(t2.won="away" and t2.awayteam=t1.id) as `won_away`,
              (sum(t2.won="home" and t2.hometeam=t1.id)+sum(t2.won="away" and t2.awayteam=t1.id))*3 + sum(t2.won="tie") as `points`
            FROM `teams` t1
            JOIN games t2 ON (t1.id = t2.hometeam OR t1.id = t2.awayteam) AND t2.won IS NOT NULL ',
            '',
            'GROUP BY t1.id
            ORDER BY `points` DESC '
        ];
        
        
        if($teamId !== null && is_numeric($teamId)) {
            $sql[1] = ' WHERE t1.id = ? ';
            
            $result = $modelInstance->getConnection()->select(join($sql), [$teamId]);
            if(is_array($result) && count($result) === 1) return $result[0];
            else return $result;
        }
        else return $modelInstance->getConnection()->select(join($sql));
    }
    
    
    public function GetPlayersCount() {
        return Roster::
            select($this->getConnection()->raw('COUNT(*) as `count`'))
            ->where('season_id', '=', $this->getConnection()->raw(Season::GetActual()->id))
            ->where('team_id', '=',  $this->getConnection()->raw($this->id))
            ->first()
            ->count;
    }
    
    
    public function GetPlayers() {
        return Players::
            select($this->getConnection()->raw('`players`.*'))
            ->join('roster', function($join){
                $join->on('players.id', '=', 'roster.player_id');
                $join->where('roster.season_id', '=', $this->getConnection()->raw(Season::GetActual()->id));
                $join->where('roster.team_id', '=', $this->id);
            })
            ->get();
    }
    
    
    public function GetGames() {
        return Games::where(function ($query) {
                    $query->where('hometeam', $this->id)
                        ->orWhere('awayteam', $this->id);
                })->where('season_id', '=', $this->getConnection()->raw(Season::GetActual()->id))
                ->orderBy('date', 'asc')
                ->get();
    }
    
    
    /**
     * Returns all time best shooter of team
     */
    public function GetBestShooter() {
        $scoreList  = ScoreList::
            select($this->getConnection()->raw('score_list.player_id, SUM(value) AS `sum`'))
            ->groupBy('score_list.player_id')
            ->join('roster', function($join){
                $join->on('score_list.player_id', '=', 'roster.player_id');
                $join->on('roster.season_id', '=', $this->getConnection()->raw(Season::GetActual()->id));
                $join->on('roster.team_id', '=', $this->getConnection()->raw($this->id));
            })
            ->orderBy('sum', 'desc')
            ->first();
            
        $player     = is_object($scoreList)
            ? Players::find($scoreList->player_id)
            : null;
        
        
        return is_object($player) == false
            ? null
            : [
                'score'     => $scoreList->sum,
                'player'    => $player
            ];
    }
    
    
    public function GetHistory() {
        if($this->history === null) {
            $this->history =  [
                'won'   => Games::wonBy($this->id)->count(),
                'lost'  => Games::lostBy($this->id)->count()
            ];
        }
        
        return $this->history;
    }
    
    
    public static function GetList() {
        return static::all();
    }
    
    
    /**
     *  Get list of teams as array indexed by team id
     */
    public static function GetTeamsIndexedArray() {
       $teams = [];
       foreach(Static::cursor() as $team) {
            $teams[$team->id] = $team;
        }
        
        return $teams;
   }
   
   
   public static function GetTeamsNames() {
        return static::select('name', 'short')
            ->orderBy('name', 'asc')
            ->get();
   }
}