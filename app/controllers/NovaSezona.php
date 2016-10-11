<?php
namespace KSL\Controllers;

use \KSL\Models;
use \Illuminate\Database\Connection;

class NovaSezona extends Base
{
    public function show($request, $response, $args) {
    
        return $response->write( $this->ci->twig->render('nova_sezona.tpl', [
            'navigationSwitch'      => 'admin',
            'teams'                 => Models\Teams::GetList(),
            'playgrounds'           => Models\Playground::Select('id', 'name')->Get()
        ]));
    }
   
   
    // Post page to generate schedule
    public function generate($request, $response, $args) {
        $data            = $request->getParsedBody();
        
        
        //
        // Verify post data
        //
        $start           = strtotime( filter_var($data['start'], FILTER_SANITIZE_STRING) );
        $weekDays        = array_map( 'intval', $data['week_days']);
        $exludedDays     = array_map( 
            function($day) { return \DateTime::createFromFormat('j.n', trim($day))->setTime(0,0,0)->getTimestamp(); }, 
            array_filter(explode(',', $data['excluded_days']))
        );
        
        
        $teamsIDs        = array_map('intval', array_keys($data['team']));
        // Shuffle option is missing!
        //if($data['shuffle'] == 1) shuffle($teamsIDs);
        
        
        $startTime          = ((int) $data['start_time']) * 60*60;  // Time when games starts each day (in seconds)
        $gameDuration       = 2 * (30 * 60) + 5 * 60;               // 2x30min + 5min
        $pause              = ((int) $data['pause']) * 60;          // Delay between games (in seconds)
        $simultaneous       = (int) $data['simultaneous'];          // Number of games played simultaneously (or number of playgrounds)
        $dayMax             = (int) $data['day_max'];               // Maximum number of games per one day
        $teamDayMax         = (int) $data['team_day_max'];          // Maximum number of games a team can play per one day
        $playgrounds        = array_map('intval', $data['playgrounds']); // List of playgrounds IDs
        
        
        //
        // Generate schedule
        //
        $gamesList          = $this->GetListOfGames($teamsIDs);
        $playingDates       = $this->GetPlayingDays($start, $weekDays, $exludedDays);
        $schedule           = $this->GetSchedule($gamesList, $playgrounds, $playingDates, $teamsIDs, $startTime, $gameDuration, $pause, $simultaneous, $dayMax, $teamDayMax);
        


        $teams          = Models\Teams::GetList();
        $teamsById      = [];
        foreach($teams as $team)
            $teamsById[$team->id] = $team;
            
            
        $playgroundsAll     = Models\Playground::Select('id', 'name')->Get();
        $playgroundsNames   = [];
        foreach($playgroundsAll as $playground) {
            if(in_array($playground->id, $playgrounds)) $playgroundsNames[$playground->id] = $playground->name;
        }
            

        

        return $response->write( $this->ci->twig->render('new_season_check.twig', [
            'navigationSwitch'      => 'admin',
            'teams'                 => $teamsById,
            'playgroundsNames'      => $playgroundsNames,
            'schedule'              => $schedule,
            'twigSchedule'          => $this->PrepareScheduleForTwig($schedule, $playgrounds, $teamsById)
        ]));
    }
   
   
    //
    // Returns timestamps of days starting from $start to one year. 
    //
    // $start - (int) timestamp of start day
    // $weekDays - (array of int) list of days of week that can be returned in ISO-8601/date("N") format (1=Monday,7=Sunday)
    // $excludedDays - (array of int) list of days (timestamps) that will be excluded from returned array
    //
    //
    // TODO: It may be more effective to change this to GetNextPlayingDay() and call it directly from GetSchedule()
    //
    private function GetPlayingDays($start, array $weekDays, array $excludedDays) {
       $oneDay      = 60*60*24;
       $oneYear     = $oneDay * 365;
       $ending      = $start + $oneYear;
       $playingDays = [];
    
       for($day = $start; $day <= $ending; $day += $oneDay) {
           // Is this a playing day?
           if( in_array(date('N', $day), $weekDays) === false ) continue;
    
           // Is this day excluded?
           if( in_array($day, $excludedDays) === true) continue;
           
           // Add day
           $playingDays[] = $day;
       }
       
       return $playingDays;
    }
    
    
    //
    // Get list of games (first vs second, first vs third, first vs fourth, second vs third, ...)
    // Returned list consists of arrays of IDs of teams playing agaisnt each other
    // returns [ [teamID-1, teamID-2], [teamID-1, teamID-3], ... ]
    //
    // $teamsIDs - array of numeric IDs of teams
    private function GetListOfGames(array $teamsIDs) {
        $list           = [];
        $teamsCount     = count($teamsIDs);
        
        for($team1 = 0; $team1 < $teamsCount - 1; $team1++) {
            for($team2 = $team1 + 1; $team2 < $teamsCount; $team2++)
                $list[] = [ $teamsIDs[$team1], $teamsIDs[$team2] ];
        }
        
        return $list;
    }
    
    
    // Get playground that isn't currently played on
    //
    // $playgrounds - array of playgrounds IDs
    // $schedule - schedule array (format of what GetSchedule returns)
    // $time - current timestamp that the next match will be played at
    private function GetPlayground(array $playgrounds, array $schedule, $time) {
        // Get list of games played at current time (if any)
        $lastGames              = array_key_exists($time, $schedule) && is_array($schedule[$time]) ? $schedule[$time] : null;
        // Get list of playgrounds currently in use (if any)
        $usedPlaygrounds        = is_array($lastGames) ? array_keys($lastGames) : [];
        
        // Loop through all playgrounds and return one that isn't currently used
        foreach($playgrounds as $playground) {
            if(in_array($playground, $usedPlaygrounds) === false)
                return $playground;
        }
        
        
        return false;
    }
    
    
    //
    // $teamsGamesCount - count of games each team already have current day
    // $teamsGamesCount - count of games each team already have scheduled
    // $playgroundsCurrentGames - list of current games on other playgrounds
    // $gamesList - list of available games not yet assigned
    // $teamDayMax - maximum number of games one team can play per one day
    private function GetAvailAbleMatch(array $teamsDayGamesCount, array $teamsGamesCount, array $playgroundsCurrentGames, array $gamesList, $teamDayMax) {
        // Transform $playgroundsCurrentGames to format where values will be list of teams IDs 
        // so we get a list of teams already playing on another playground
        $playgroundsCurrentGames      = count($playgroundsCurrentGames) > 1 ? call_user_func_array('array_merge', $playgroundsCurrentGames) : $playgroundsCurrentGames;
        
        // Order games list by number of matches teams already play
        // so put first those matches whose teams plays fewest games yet
        // key is joined match (TeamID1:TeamID2) and value is score, where
        // score is sum of already played games of each team
        $gamesListJoined  = [];
        foreach($gamesList as $game) {
            $key = join(':', $game);
            $gamesListJoined[$key] = $teamsDayGamesCount[$game[0]] + $teamsDayGamesCount[$game[1]] + $teamsGamesCount[$game[0]] + $teamsGamesCount[$game[1]];
        }
        
        
        // Now sort the games list
        $gamesListSorted = &$gamesListJoined;
        asort($gamesListJoined);
        
        
        // Cycle trhought list of games and select first those teams
        // aren't already playing on another playground and teams
        // aren't over $teamDayMax limit
        foreach($gamesListSorted as $key => $score) {
            $teams = explode(':', $key);

            if(in_array($teams[0], $playgroundsCurrentGames) === false && in_array($teams[1], $playgroundsCurrentGames) === false
                && $teamsDayGamesCount[$teams[0]] < $teamDayMax && $teamsDayGamesCount[$teams[1]] < $teamDayMax)
                    return $teams;
        }
        
        return false;
    }
    
    
    //
    // Get list of games (their timestamps and teams IDs)
    //
    // $gamesList - list of games (output of GetListOfGames) [[teamID-1, teamID-2], [teamId-1, teamId-3], ...]
    // $playgrounds - list of IDs of playgrounds to play on
    // $playingDates - List of playing days (timestamps)
    // $teamsIDs - list of team's IDs
    // $startTime - time at which games starts each day (numeric hour in pm)
    // $gameDuration - duration of one game (in seconds)
    // $pause - pause between games (in seconds)
    // $simultaneous - number of games played simultaneously (or number of playgrounds)
    // $dayMax - maximum number of games that can be played per one day, if set to 0 it will be automatically determined
    // $teamDayMax - maximum number of games a team can play per one day
    //
    // RETURN: array of result games at playgrounds and times
    // $a = [ timestamp => [ playgroundId1 => [team1, team2], playgroundsId2 => [ ... ], ...], ... ]
    //
    private function GetSchedule(array $gamesList, array $playgrounds, array $playingDates, array $teamsIDs, $startTime, $gameDuration, $pause, $simultaneous, $dayMax, $teamDayMax) {
        $schedule           = [];
        
        
        // If day max is set to "0" (which represents auto) then
        // determine maximum possible number of games per day
        if($dayMax === 0) $dayMax = floor(count($teamsIDs) / 2);
        
        
        
        $zeroedTimesIDs                 = array_fill_keys( array_values($teamsIDs), 0);         // Array of teams ids with zero value for each index
        $teamsDayGamesCount             = $zeroedTimesIDs;                                      // Number of games each team play current day
        $teamsGamesCount                = $zeroedTimesIDs;                                      // Number of games each team already has in schedule
        $playgroundsCurrentGames        = [];                                                   // List of current games (at $time) [ playgroundId => [TeamId1, TeamId2], ... ]
        $currentDay                     = reset($playingDates);                                 // Get first playing day from list of game dates
        $time                           = $currentDay + $startTime;                             // Count of games at current day
        $currentDayGamesCount           = 0;                                                    // Count of today's games
        
        // Debug variable to prevent infinite loops
        $temp = 500;
        
        
        //
        // Loop through games and assign them to schedule until there's no more games left
        //
        if(count($playgrounds) > 0 && count($gamesList) > 0) while( count($gamesList) > 0 ) {
            if(--$temp < 0) throw new Exception('GetSchedule loop had too many iterations');
            
            
            // If number of games of current day is less then day maximum
            if($currentDayGamesCount < $dayMax) {
                // Find free playground
                $playground         = $this->GetPlayground($playgrounds, $schedule, $time);
            
            
                if($playground !== false) {
                    // Try to get next available game from list
                    $game                          = $this->GetAvailAbleMatch($teamsDayGamesCount, $teamsGamesCount, $playgroundsCurrentGames, $gamesList, $teamDayMax);
                    
                    if($game !== false) {
                        // If game found, add it to schedule
                        $schedule[$time][$playground]   = $game;
                        
                        // Increment all counters
                        $teamsDayGamesCount[$game[0]]++;
                        $teamsDayGamesCount[$game[1]]++;
                        $teamsGamesCount[$game[1]]++;
                        $teamsGamesCount[$game[1]]++;
                        $currentDayGamesCount++;
                        
                        // Get key of game in gamesList and delete game from list
                        $roundKey = array_search($game, $gamesList);
                        unset($gamesList[$roundKey]);
                        
                        continue;
                    }
                }
                
                
                // If no playground is available now, increment time and continue
                else {
                    $time += $gameDuration + $pause;
                    continue;
                }
            }
            
            
            // If no available game was found and assigned to schedule, try it next day :)
            $currentDay                 = next($playingDates);
            $time                       = $currentDay + $startTime;
            $currentDayGamesCount       = 0;
            $teamsDayGamesCount         = $zeroedTimesIDs;
        }
        
        
        return $schedule;
    }


    public function PrepareScheduleForTwig(&$schedule, &$playgrounds, &$teamsById) {
        $formated = [];
        
        $currentDay = null;
        $day        = [];
        $emptyDay   = array_fill_keys($playgrounds, '');
        
        foreach($schedule as $timestamp => $playground) {
            if($currentDay === null) $currentDay = date('dm', $timestamp);
            
            foreach($playground as $playgroundId => $game) {
                if($currentDay != date('dm', $timestamp)) {
                    $currentDay             = date('dm', $timestamp);
                    $formated[$timestamp]   = $day;
                    $day            = [];
                }
                
                if(array_key_exists($timestamp, $day) === false)
                    $day[$timestamp] = $emptyDay;
                
                
                $day[$timestamp][$playgroundId] = $teamsById[$game[0]]->short.' @ '.$teamsById[$game[1]]->short;
            }
        }
        
        $formated[$timestamp]     = $day;
        
        return $formated;
    }
}