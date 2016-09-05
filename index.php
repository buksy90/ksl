<?php

/**
 * Step 1: Require the Slim Framework using Composer's autoloader
 *
 * If you are not using Composer, you need to load Slim Framework with your own
 * PSR-4 autoloader.
 */
define('DIR_ROOT', __DIR__);
require DIR_ROOT.'/vendor/autoload.php';

use \Illuminate\Database\Connection;
use \KSL\Models;


$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$config['db']['driver']         = 'mysql';
$config['db']['host']           = getenv('IP');
$config['db']['username']       = getenv('C9_USER');
$config['db']['password']       = '';
$config['db']['database']       = 'c9';
$config['db']['collation']      = 'utf8_general_ci';
$config['db']['charset']        = 'utf8';
$config['db']['port']           = 3306;

$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($config['db']);

$capsule->setAsGlobal();
$capsule->bootEloquent();


spl_autoload_register(function ($classname) {
    if(substr($classname, 0, 11) === 'KSL\Models\\')
        require (DIR_ROOT . '/app/models/' . substr($classname, 11) . ".php");
        
    return false;
});


/**
 * Step 2: Instantiate a Slim application
 *
 * This example instantiates a Slim application using
 * its default settings. However, you will usually configure
 * your Slim application now by passing an associative array
 * of setting names and values into the application constructor.
 */
$app        = new Slim\App(['settings' => $config]);
$container  = $app->getContainer();


//
// Set up db
//
/*
$container['db'] = function ($c) {
    $db = $c['settings']['db'];
    $pdo = new PDO("mysql:host=" . $db['host'] . ";dbname=" . $db['dbname'],
        $db['user'], $db['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};
*/



//
// Set up twig
//
$container['twig']  = function($c) {
    $loader         = new Twig_Loader_Filesystem(DIR_ROOT.'/views');
    $env            = new Twig_Environment($loader, array(
        //'cache' => '/cache'
        'debug'                 => true,
        'strict_variables'      => true
    ));
    
    $env->addExtension(new Twig_Extension_Debug());
    
    $env->addGlobal('router', $c['router']);
    $env->addGlobal('navigation', null);
    
    $env->addGlobal('navigation', [
        [ 'route' => 'index', 'text' => 'Úvod', 'navigationSwitch' => null ],
        [ 'route' => 'rozpis', 'text' => 'Rozpis', 'navigationSwitch' => 'rozpis' ],
        [ 'route' => 'tabulka', 'text' => 'Tabuľky', 'navigationSwitch' => 'tabulka' ],
        [ 'route' => 'o-nas', 'text' => 'O nás', 'navigationSwitch' => 'o-nas' ],
    ]);
    //$env->addGlobal('request', $c['request']);

    return $env;
};

/**
 * Step 3: Define the Slim application routes
 *
 * Here we define several Slim application routes that respond
 * to appropriate HTTP request methods. In this example, the second
 * argument for `Slim::get`, `Slim::post`, `Slim::put`, `Slim::patch`, and `Slim::delete`
 * is an anonymous function.
 */
$app->get('/', function ($request, $response, $args) {
    return $response->write( $this->twig->render('layout.tpl', [
        'navigationSwitch' => null
    ]));
})->setName('index');


$app->get('/o-nas', function ($request, $response, $args) {
    return $response->write( $this->twig->render('o-nas.tpl', [
        'navigationSwitch' => 'o-nas'
    ]));
})->setName('o-nas');


$app->get('/rozpis', function ($request, $response, $args) {
    
    return $response->write( $this->twig->render('rozpis.tpl', [
        'navigationSwitch' => 'rozpis'
    ]));
})->setName('rozpis');


$app->get('/tabulka', function ($request, $response, $args) {
    $teams = Models\Teams::select('id', 'name')->get()->map(function(Models\Teams $team){
        $games      = Models\Games::playedBy($team->id)->count();
        $won        = Models\Games::wonBy($team->id)->count();
        $lost       = Models\Games::lostBy($team->id)->count();
        $points     = $lost + $won * 2;
        $success    = $games === 0 ? 0 : ($won / $games) * 100;
        $scored     = Models\Games::where([['won', 'home'], ['hometeam', $team->id]])->sum('home_score') + Models\Games::where([['won', 'away'], ['awayteam', $team->id]])->sum('away_score');
        $received   = Models\Games::where([['won', 'away'], ['hometeam', $team->id]])->sum('home_score') + Models\Games::where([['won', 'home'], ['awayteam', $team->id]])->sum('away_score');
        
        return [
            'teamObj'       => $team,
            'games'         => $games,
            'won'           => $won,
            'lost'          => $lost,
            'points'        => $points,
            'success'       => $success,
            'scored'        => $scored,
            'received'      => $received
        ];
    });
    
    
    $shooters = Models\Players::join(Models\Roster::getTableName(), function($join){
        $join->on('players.id', '=', 'roster.player_id');
        $join->on(Models\Roster::getTableName().'.year', '=', Connection::raw('"'.date('Y').'"'));
    })->get()->map(function($player){
        $team       = Models\Teams::first($player->attributes['team_id']);
        
        $games      = Models\ScoreList::select(Connection::raw('count(DISTINCT `'.Models\ScoreList::getTableName().'`.`player_id`) as count'))
            ->where(Models\ScoreList::getTableName().'.player_id', Connection::raw('"'.$player->id.'"'))
            ->groupBy('game_id')
            ->groupBy(Models\Roster::getTableName().'.player_id')
            ->join(Models\Roster::getTableName(), function($join){
                $join->on(Models\ScoreList::getTableName().'.player_id', '=', Models\Roster::getTableName().'.player_id');
                $join->on(Models\Roster::getTableName().'.year', '=', Connection::raw('"'.date('Y').'"'));
            })->first();


        $points      = Models\ScoreList::select(Connection::raw('sum(`'.Models\ScoreList::getTableName().'`.`value`) as "sum"'))
            ->where(Models\ScoreList::getTableName().'.player_id', Connection::raw('"'.$player->id.'"'))
            ->groupBy('game_id')
            ->groupBy(Models\Roster::getTableName().'.player_id')
            ->join(Models\Roster::getTableName(), function($join){
                $join->on(Models\ScoreList::getTableName().'.player_id', '=', Models\Roster::getTableName().'.player_id');
                $join->on(Models\Roster::getTableName().'.year', '=', Connection::raw('"'.date('Y').'"'));
            })->first();

        return [
            'playerObj'         => $player,
            'team'              => $team->name,
            'games'             => $games->count == null ? 0 : $games->count,
            'points'            => $points->sum == null ? 0 : $points->sum,
            'avg'               => $games->count > 0 ? $points->sum / $games->count : 0
        ];
    })->toArray();
    usort($shooters, function($a, $b){
        return $b['avg'] - $a['avg'];
    });
    
    
    $shooters3pt = Models\Players::join(Models\Roster::getTableName(), function($join){
        $join->on('players.id', '=', 'roster.player_id');
        $join->on(Models\Roster::getTableName().'.year', '=', Connection::raw('"'.date('Y').'"'));
    })->get()->map(function($player){
        $team       = Models\Teams::first($player->attributes['team_id']);
        
        $games      = Models\ScoreList::select(Connection::raw('count(DISTINCT `'.Models\ScoreList::getTableName().'`.`player_id`) as count'))
            ->where(Models\ScoreList::getTableName().'.player_id', Connection::raw('"'.$player->id.'"'))
            ->groupBy('game_id')
            ->groupBy(Models\Roster::getTableName().'.player_id')
            ->join(Models\Roster::getTableName(), function($join){
                $join->on(Models\ScoreList::getTableName().'.player_id', '=', Models\Roster::getTableName().'.player_id');
                $join->on(Models\Roster::getTableName().'.year', '=', Connection::raw('"'.date('Y').'"'));
            })->first();


        $points      = Models\ScoreList::select(Connection::raw('sum(`'.Models\ScoreList::getTableName().'`.`value`) as "sum"'))
            ->where(Models\ScoreList::getTableName().'.player_id', Connection::raw('"'.$player->id.'"'))
            ->where(Models\ScoreList::getTableName().'.value', Connection::raw('"3"'))
            ->groupBy('game_id')
            ->groupBy(Models\Roster::getTableName().'.player_id')
            ->join(Models\Roster::getTableName(), function($join){
                $join->on(Models\ScoreList::getTableName().'.player_id', '=', Models\Roster::getTableName().'.player_id');
                $join->on(Models\Roster::getTableName().'.year', '=', Connection::raw('"'.date('Y').'"'));
            })->first();

        return [
            'playerObj'         => $player,
            'team'              => $team->name,
            'games'             => $games->count == null ? 0 : $games->count,
            'points'            => $points->sum == null ? 0 : $points->sum,
            'avg'               => $games->count > 0 ? $points->sum / $games->count : 0
        ];
    })->toArray();
    usort($shooters3pt, function($a, $b){
        return $b['avg'] - $a['avg'];
    });
    
    return $response->write( $this->twig->render('tabulka.tpl', [
        'navigationSwitch'      => 'tabulka',
        'teams'                 => $teams,
        'shooters'              => $shooters,
        'shooters3pt'           => $shooters3pt
    ]));
})->setName('tabulka');

$app->get('/hello[/{name}]', function ($request, $response, $args) {
    $response->write("Hello, " . $args['name']);
    return $response;
})->setArgument('name', 'World!');

/**
 * Step 4: Run the Slim application
 *
 * This method should be called last. This executes the Slim application
 * and returns the HTTP response to the HTTP client.
 */
$app->run();
