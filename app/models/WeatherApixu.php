<?php
// https://www.apixu.com/my/#_=_
namespace KSL\Models;

class WeatherApixu
{
    public function Fetch() {
        $key        = "0c3cad905d354dc7a26113931170902";
        $city       = 'kosice, slovakia';
        //$url = "http://api.apixu.com/v1/current.json?key=$key&q=paris&=" ;
        $url        = [
            'forecast'      => 'http://api.apixu.com/v1/forecast.json?key=0c3cad905d354dc7a26113931170902&q='.$city,
            'current'       => 'http://api.apixu.com/v1/current.json?key=0c3cad905d354dc7a26113931170902&q='.$city
        ];
    
        $ch = curl_init();  
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    
        $json_output=curl_exec($ch);
        $weather = json_decode($json_output);
        
        
        var_dump($weather);
    }
}