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
        $exludedDays     = array_map( function($day){ return \DateTime::createFromFormat('j.n', trim($day))->setTime(0,0,0)->getTimestamp(); }, explode(',', $data['excluded_days']));
        $playingDates    = $this->GetPlayingDays($start, $weekDays, $exludedDays);
        
        
        //foreach($playingDates as $d)
            //echo("\n".date("d.m.Y H:i l", $d).", ".$d."<br>");
        
        
        return null;
        return $response->write( $this->ci->twig->render('nova_sezona.tpl', [
            'navigationSwitch'      => 'admin',
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
    
}