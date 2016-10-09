<?php
namespace KSL\Controllers;

use \KSL\Models;
use \Illuminate\Database\Connection;

class NovaSezona extends Base
{
    public function show($request, $response, $args) {
    
        return $response->write( $this->ci->twig->render('nova_sezona.tpl', [
            'navigationSwitch'      => 'admin',
            'teams'                 => Models\Teams::GetList()
        ]));
    }
   
   
    public function generate($request, $response, $args) {
        $data            = $request->getParsedBody();
        $schedule        = [];
        $matches         = [];
        
        print_r($data);
        
        
        // Get playinh days
        $start           = strtotime( filter_var($data['start'], FILTER_SANITIZE_STRING) );
        $weekDays        = array_map( 'intval', $data['week_days']);
        $exludedDays     = array_map( 
            function($day) { return \DateTime::createFromFormat('j.n', trim($day))->setTime(0,0,0)->getTimestamp(); }, 
            array_filter(explode(',', $data['excluded_days']))
        );
        $playingDates    = $this->GetPlayingDays($start, $weekDays, $exludedDays);
        
        
        // get rounds matches (each vs each)
        $teamsIDs        = array_map('intval', array_keys($data['team']));
        // Shuffle option is missing on template !
        //if($data['shuffle'] == 1) shuffle($teamsIDs);
        $gamesList       = $this->GetListOfGames($teamsIDs);
        var_dump("Games list:");
        print_r($gamesList);
        
        
        //
        // Assign games to days
        //
        $startTime          = ((int) $data['start_time']) * 60*60;  // Time when games starts (in seconds)
        $gameDuration       = 2 * (30 * 60) + 5 * 60;               // 2x30min + 5min
        $pause              = ((int) $data['pause']) * 60;          // Delay between games (in seconds)
        $simultaneous       = (int) $data['simultaneous'];          // Number of games played simultaneously (or number of playgrounds)
        $dayMax             = (int) $data['day_max'];               // Maximum number of games per one day
        $teamDayMax         = (int) $data['team_day_max'];          // Maximum number of games a team can play per one day
        
        // Schedule with matches, indexes are timestamps, values are arrays of teams IDs playing against each other
        $schedule           = $this->GetSchedule($gamesList, $playingDates, $teamsIDs, $startTime, $gameDuration, $pause, $simultaneous, $dayMax, $teamDayMax);
        

        
        if(is_array($schedule)) foreach($schedule as $time => $playgrounds) {
            foreach($playgrounds as $playgroundId => $game) 
                echo("\nPlayground: ".$playgroundId.date(", d.m. H:i = ", $time).$game[0].' - '.$game[1]);
        }
        else var_dump($schedule);


        $teams          = Models\Teams::GetList();
        $teamsById      = [];
        foreach($teams as $team)
            $teamsById[$team->id] = $team;
            

die();
        return $response->write( $this->ci->twig->render('nova_sezona2.tpl', [
            'navigationSwitch'      => 'admin',
            'teams'                 => $teamsById,
            'schedule'              => $schedule,
        ]));
    }
   
   
    //
    // Returns timestamps of days starting from $start to one year. 
    //
    // $start - (int) timestamp of start day
    // $weekDays - (array of int) list of days of week that can be returned in ISO-8601/date("N") format (1=Monday,7=Sunday)
    // $excludedDays - (array of int) list of days (timestamps) that will be excluded from returned array
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
    
    
    // Schedule format
    // $a = [ timestamp => [ playgroundId1 => [team1, team2], playgroundsId2 => [ ... ], ...], ... ]
    //
    // $playgrounds - array of playgrounds IDs
    // $schedule - schedule array
    // $time - current timestamp
    private function GetPlayground(array $playgrounds, array $schedule, $time) {
        $lastGames              = array_key_exists($time, $schedule) && is_array($schedule[$time]) ? $schedule[$time] : null;
        $usedPlaygrounds        = is_array($lastGames) ? array_keys($lastGames) : [];
        
        var_dump($usedPlaygrounds);
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
    // $teamDayMax - maximum number of games one team can play one day
    private function GetAvailAbleMatch(array $teamsDayGamesCount, array $teamsGamesCount, array $playgroundsCurrentGames, array $gamesList, $teamDayMax) {
        // Transform $playgroundsCurrentGames to format where values will be list of teams IDs 
        // so we get a list of teams already playing on another playground
        $playgroundsCurrentGames      = count($playgroundsCurrentGames) > 1 ? call_user_func_array('array_merge', $playgroundsCurrentGames) : $playgroundsCurrentGames;
        
        // Order games list by number of matches teams already play
        // so put first those matches whose teams plays fewest games yet
        // key is joined match (TeamID1:TeamID2) and value is score, where
        // score is sum of already played games of each team
        $gamesListSorted  = [];
        foreach($gamesList as $game) {
            $key = join(':', $game);
            $gamesListSorted[$key] = $teamsDayGamesCount[$game[0]] + $teamsDayGamesCount[$game[1]] + $teamsGamesCount[$game[0]] + $teamsGamesCount[$game[1]];
        }
        
        // Now sort the games list
        asort($gamesListSorted);
        
        // Cycle trhought list of games and select first those teams
        // aren't already playing on another playground
        reset($gamesListSorted);

$temp = 0;
        //while( list($key, $score) = each($gamesListSorted)) {
        foreach($gamesListSorted as $key => $score) {
            $teams = explode(':', $key);

            // If none of the teams are already playing, return this match
            if(in_array($teams[0], $playgroundsCurrentGames) === false && in_array($teams[1], $playgroundsCurrentGames) === false
                && $teamsDayGamesCount[$teams[0]] < $teamDayMax && $teamsDayGamesCount[$teams[1]] < $teamDayMax) {
                    var_dump("Returning match ".$key);
                    return $teams;
            }
                

if(++$temp > 30) {
    var_dump('CYCLE ERROR '.__LINE__);
    break;
}

        }
        
        var_dump("No avail match");
        var_dump($gamesListSorted);
        return false;
    }
    
    
    //
    // Get list of games (their timestamps and teams IDs)
    //
    // $gamesList - list of games (output of GetListOfGames)
    // $playingDates - List of playing days (timestamps)
    // $teamsIDs - list of team's IDs
    // $startTime - time at which games starts each day (numeric hour in pm)
    // $gameDuration - duration of one game (in seconds)
    // $pause - pause between games (in seconds)
    // $simultaneous - number of games played simultaneously (or number of playgrounds)
    // $dayMax - maximum number of games that can be played per one day, if set to 0 it will be automatically determined
    // $teamDayMax - maximum number of games a team can play per one day
    private function GetSchedule(array $gamesList, array $playingDates, array $teamsIDs, $startTime, $gameDuration, $pause, $simultaneous, $dayMax, $teamDayMax) {
        // Array of result matches
        // Format
        // $a = [ timestamp => [ playgroundId1 => [team1, team2], playgroundsId2 => [ ... ], ...], ... ]
        $schedule           = [];
        
        $rounds             = $gamesList;                                   // list of all games (teamID-1 vs teamID-2, teamId-1 vs teamId-3, ...)
        $currentDay         = reset($playingDates);                 // timestamp of first playing day
        $playgrounds        = [ 1, 2 ];                                // List of playgrounds IDs
        
        // If day max is set to "0" (which represents auto) then
        // determine maximum possible number of games per day
        if($dayMax === 0) $dayMax = floor(count($teamsIDs) / 2);
        
        
        // Number of games each team play current day
        $teamsDayGamesCountDefault      = array_fill_keys( array_values($teamsIDs), 0);
        $teamsDayGamesCount             = $teamsDayGamesCountDefault;
        $teamsGamesCount                = $teamsDayGamesCountDefault;
        $playgroundsCurrentGames        = [];
        $time                           = $currentDay + $startTime;
        $currentDayMatchesCount         = 0;
        
        $temp = 0;
        
        if(count($playgrounds) > 0 && count($rounds) > 0) while( count($rounds) > 0 ) {
            if(++$temp > 20) {
                var_dump('CYCLE ERROR '.__LINE__);
                break;
            }
            
            // If number of matches of current day is less then day maximum
            if($currentDayMatchesCount < $dayMax) {
                $playground         = $this->GetPlayground($playgrounds, $schedule, $time);
            
            
                if($playground !== false) {
                    $match                          = $this->GetAvailAbleMatch($teamsDayGamesCount, $teamsGamesCount, $playgroundsCurrentGames, $rounds, $teamDayMax);
                    if($match !== false) {
                        echo("Adding match at plaground ".$playground.", match ".join(":", $match).PHP_EOL);
                        $schedule[$time][$playground]   = $match;
                        $teamsDayGamesCount[$match[0]]++;
                        $teamsDayGamesCount[$match[1]]++;
                        $teamsGamesCount[$match[1]]++;
                        $teamsGamesCount[$match[1]]++;
                        
                        $roundKey = array_search($match, $rounds);
                        unset($rounds[$roundKey]);
                        
                        ++$currentDayMatchesCount;
                        continue;
                    }
                    else var_dump("Match = FALSE");
                }
                else {
                    var_dump("Playground = FALSE");
                    $time += $gameDuration + $pause;
                    continue;
                }
            }
            
            
            
            var_dump('======= NEW DAY ========');
            // If no game was assigned, go to next day
            $currentDay                 = next($playingDates);
            $time                       = $currentDay + $startTime;
            $currentDayMatchesCount     = 0;
            $teamsDayGamesCount         = $teamsDayGamesCountDefault;
            
        }
        
        
        return $schedule;
        
        
        
        
        
        /*
        $schedule           = [];                                   // Schedule with matches, indexes are timestamps, values are arrays of teams IDs playing against each other
        $rounds             = array_merge( $gamesList, $gamesList );// list of all games (teamID-1 vs teamID-2, teamId-1 vs teamId-3, ...)
        $currentDay         = reset($playingDates);                 // timestamp of first playing day

        
        // If day max is set to "0" (which represents auto) then
        // determine maximum possible number of games per day
        if($dayMax === 0) $dayMax = floor(count($teamsIDs) / 2);
        
        while( count($rounds) > 0 ) {
            // Games count each team play current day
            //$todayTeamGames     = array_fill_keys($teamsIDs, 0);
            $time               = $currentDay + $startTime;
            
            for($i = 0; $i < $dayMax; $i++) {
                // Take one game from list (it doesnt matter whether its the first or last one,
                // but array_pop will be faster than array_unshift with reindexing)
                $game = array_pop($rounds);
                
                //while( $todayTeamGames[$game[0]] > $)
                $schedule[$time] = $game;
                
                $time += $gameDuration + $pause;
            }
            
            $currentDay         = next($playingDates);
        }
        
        return $schedule;
        */
    }

}