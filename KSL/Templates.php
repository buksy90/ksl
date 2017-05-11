<?php
namespace KSL;

class Templates {
    public static function getTwig($container) {
        $loader         = new \Twig_Loader_Filesystem(DIR_ROOT.'/views');
        $env            = new \Twig_Environment($loader, array(
            //'cache' => '/cache'
            'debug'                 => true,
            'strict_variables'      => true
        ));
        
        $env->addExtension(new \Twig_Extension_Debug());
        
        $env->addGlobal('router', $container['router']);
        $env->addGlobal('navigation', null);
        
        $env->addGlobal('navigation', [
            [ 'route' => 'index', 'text' => 'Úvod', 'navigationSwitch' => null ],
            [ 'route' => 'rozpis', 'text' => 'Rozpis', 'navigationSwitch' => 'rozpis' ],
            [ 'route' => 'tabulka', 'text' => 'Tabuľky', 'navigationSwitch' => 'tabulka' ],
            //[ 'route' => 'o-nas', 'text' => 'O nás', 'navigationSwitch' => 'o-nas' ],
            [ 'route' => 'playground', 'text' => 'Ihriská', 'navigationSwitch' => 'playground' ],
        ]);


        $env->addGlobal('teamsNames', \KSL\Models\Teams::GetTeamsNames());

        return $env;
    }
}