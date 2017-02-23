<?php
// https://www.apixu.com/my/#_=_
namespace KSL\Models;
use \Illuminate\Database\Connection;

class Weather extends Base
{
    protected $table    = 'weather';
    public $timestamps  = false;
    
    
    //
    // Truncate Weather table, download new forecast and fill table
    //
    public function UpdateDB() {
        $weather    = $this->FetchData();
        $forecast   = $weather['forecast']['forecastday'];
        $data       = [];
        
        foreach($forecast as $day) {
            foreach($day['hour'] as $hour) {
                array_push($data, [ 'date' => $day['date'], 'hour' => $this->getHour($hour['time']), 'type' => 'temperature', 'value' => $hour['temp_c'] ]);
                array_push($data, [ 'date' => $day['date'], 'hour' => $this->getHour($hour['time']), 'type' => 'temperature_feel', 'value' => $hour['feelslike_c'] ]);
                array_push($data, [ 'date' => $day['date'], 'hour' => $this->getHour($hour['time']), 'type' => 'humidity', 'value' => $hour['humidity'] ]);
                array_push($data, [ 'date' => $day['date'], 'hour' => $this->getHour($hour['time']), 'type' => 'rain', 'value' => $hour['will_it_rain'] ]);
            }
        }
        
        
        if(count($forecast) > 5) {
            self::Truncate();
            self::Insert($data);
        }
    }
    
    
    // Extract hour from date string
    // Input format: 2017-02-25 08:00
    // Return value: 8
    private function getHour($dateString) {
        $dateString     = explode(' ', $dateString);
        $dateString     = explode(':', $dateString[1]);
        
        return (int) $dateString[0];
    }
    
    
    //
    // Download forecast data for 7 days from Apixu.com
    //
    private function FetchData() {
        $key        = "0c3cad905d354dc7a26113931170902";
        $city       = 'kosice,%20slovakia';
        $url        = [
            'forecast'      => 'http://api.apixu.com/v1/forecast.json?days=7&key='.$key.'&q='.$city,
            'current'       => 'http://api.apixu.com/v1/current.json?key='.$key.'&q='.$city
        ];
    
        /*
        $ch = curl_init();  
        curl_setopt($ch,CURLOPT_URL,$url['forecast']);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

        $json_output=curl_exec($ch);
        */
        $json       = file_get_contents($url['forecast']);
        $weather    = json_decode($json, true);
        
        return $weather;
    }
}