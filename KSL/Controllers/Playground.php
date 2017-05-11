<?php
namespace KSL\Controllers;

use \KSL\Models;
use \Illuminate\Database\Connection;

class Playground extends Base
{
    public function showList($request, $response, $args) {
        $playgrounds          = Models\Playground::GetList();
        
        return $response->write( $this->ci->twig->render('playgrounds_list.tpl', [
            'navigationSwitch'      => 'playground',
            'playgrounds'           => $playgrounds,
        ]));
   }
   
   
   public function showPlayground($request, $response, $args) {        
       $playground      = null;
       
       if(array_key_exists('link', $args)) {
            $playground     = Models\Playground::where('link', $args['link'])->first();
        }

        if($playground instanceof Models\Playground && $playground->id > 0) {
            $config         = $this->getPlayground($playground);
            $output         = $this->ci->twig->render($config->file, $config->variables);

            return $response->write( $output );
        }
        else return $this->ci['notFoundHandler']($request, $response, $args);
   }


   public function getPlayground(Models\Playground $playground) {
        $games      = Models\Games::GetNextAtPlayground($playground->id)->map(function($game){
            return [
                'date'          => $game['date'],
                'homeTeam'      => Models\Teams::select('name', 'short')->Where('id', $game['hometeam'])->first(),
                'awayTeam'      => Models\Teams::select('name', 'short')->Where('id', $game['awayteam'])->first()
            ];
        });

        return new \KSL\Helpers\TemplateConfig( 
            'playground.tpl',
            [
                'navigationSwitch'      => 'playground',
                'playground'            => $playground,
                'games'                 => $games
            ]
        );
   }
    
    
}