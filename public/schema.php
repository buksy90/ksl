<?php
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
//use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use \KSL\Models;

$team = null;

$player = New ObjectType([
    'name' => 'Player',
    'fields' => [
        'id' => [ 'type' => Type::int() ],
        'name' => [ 'type' => Type::string() ],
        'surname' => [ 'type' => Type::string() ],
        'display_name' => [ 
            'type' => Type::string(),
            'description' => 'Concatenated first and last name',
            'resolve' => function($player) {
                return $player->name . ' ' . $player->surname;
            }
        ],
        'category' => [ 'type' => Type::string() ],
        'jersey' => [ 'type' => Type::int() ],
        'team' => [
            'type' => &$team,
            'resolve' => function($root, $args) {
                $roster = Models\Roster::select('team_id')
                    ->where('player_id', $root->id)
                    ->orderBy('season_id', 'desc')
                    ->first();

                $team = Models\Teams::find($roster->team_id);

                return $team;
            }
        ]
    ]
]);


$team = new ObjectType([
    'name' => 'Team',
    'description' => 'Represents team of players',
    'fields' => [
        'id' => [ 'type' => Type::int() ],
        'name' => [ 'type' => Type::string() ],
        'short' => [ 'type' => Type::string() ],
        'captain' => [ 
            'type' => $player, 
            'resolve' => function($root, $args) {
                $team = Models\Teams::select('captain_id')->where('id', $root->id)->first();
                if($team->captain_id) {
                    $captain = Models\Players::find($team->captain_id);
                    return $captain;
                }
                
                return null;
            }
        ],
        'standing' => [ 'type' => Type::int(), 'description' => 'Position of team in standings' ],
        'score' => [ 
            'type' => Type::string(),
            'description' => 'Number of points team has scored and other teams has scored against it',
            'resolve' => function ($team) {
                return $team->points_scored . ':' . $team->points_allowed;
            }
        ],
        'current_roster' => [ 
            'type' => Type::listOf($player),
            'description' => 'Returns team players from last season',
            'resolve' => function($root, $args) {
                $roster = Models\Roster::select('player_id')
                    ->where('team_id', $root->id)
                    ->orderBy('season_id', 'desc')
                    ->get();

                $players = $roster->map(function($roster_item) {
                    return Models\Players::find($roster_item->player_id);
                });

                return $players;
            }
        ],
        'games_played' => [ 'type' => Type::int() ],
        'games_won' => [ 'type' => Type::int() ],
        'games_lost' => [ 'type' => Type::int() ],
        'points' => [ 'type' => Type::int(), 'description' => 'Number of points team has in table for wins' ],
        'points_scored' => [ 'type' => Type::int() ],
        'points_allowed' => [ 'type' => Type::int() ],
        'success_rate' => [ 'type' => Type::int() ]
    ]
]);

$types = [
    'article' => new ObjectType([
        'name' => 'Article',
        'fields' => [
            'id' => [ 'type' => Type::int() ],
            'title' => [ 'type' => Type::string() ],
            'text' => [ 'type' => Type::string() ],
            'date' => [ 'type' => Type::int() ]
        ]
    ]),

    'team' => $team,
    'player' => $player,

    'shooter' => new ObjectType([
        'name' => 'Shooter',
        'fields' => [
            'standing' => [ 'type' => Type::int() ],
            'player' => [ 'type' => $player ],
            'team' => [ 'type' => $team ],
            'games' => [ 'type' => Type::int() ],
            'points' => [ 'type' => Type::int() ],
            'average' => [ 'type' => Type::int() ],
        ]
    ]),

    'playground' => new ObjectType([
        'name' => 'Playground',
        'fields' => [
            'id' => [ 'type' => Type::int() ],
            'name' => [ 'type' => Type::string() ],
            'address' => [ 'type' => Type::string() ],
            'district' => [ 'type' => Type::string() ],
            'latitude' => [ 'type' => Type::float() ],
            'longitude' => [ 'type' => Type::float() ],
        ]
    ]),

    'date' => new ObjectType([
        'name' => 'Date',
        'fields' => [
            'timestamp' => [ 'type' => Type::int() ],
            'date' => [ 
                'type' => Type::string(),
                'description' => 'Date format that should be parsable using javascripts Date.parse()',
                'resolve' => function($date) { return date('c', $date['timestamp']); }
            ],
            'date_human' => [
                'type' => Type::string(),
                'description' => 'Date format that is easily read by human',
                'resolve' => function($date) { return date('r', $date['timestamp']); }
            ]
        ]
    ]),
];


$queries = new ObjectType([
    'name' => 'Query',
    'fields' => [
        'news' => [
            'type' => Type::listOf($types['article']),
            'resolve' => function($root, $args) {
                if(array_key_exists('id', $args)) {
                    $news = [ Models\News::find($args['id']) ];
                }
                else $news = Models\News::all();

                return $news;
            },
            'args' => [
                'id' => [ 'type' => Type::int() ]
            ]
        ],

        'teams' => [
            'type' => Type::listOf($types['team']),
            'resolve' => function($root, $args) {
                if(array_key_exists('id', $args)) {
                    $teams = [ Models\Teams::find($args['id']) ];
                }
                else $teams = Models\Teams::all();

                return $teams;
            },
            'args' => [
                'id' => [ 'type' => Type::int() ]
            ]
        ],

        'players' => [
            'type' => Type::listOf($types['player']),
            'resolve' => function($root, $args) {
                if(array_key_exists('id', $args)) {
                    $players = [ Models\Players::find($args['id']) ];
                }
                else if(array_key_exists('team_id', $args)) {
                    $roster = Models\Roster::select('player_id')
                        ->where('team_id', $args['team_id'])
                        ->orderBy('season_id', 'desc')
                        ->get();

                    $players = $roster->map(function($roster_item) {
                        return Models\Players::find($roster_item->player_id);
                    });
                }
                else $players = Models\Players::all();

                return $players;
            },
            'args' => [
                'id' => [ 'type' => Type::int() ],
                'team_id' => [ 'type' => Type::int() ]
            ]
        ],

        'team_standings' => [
            'type' => Type::listOf($types['team']),
            'resolve' => function() {
                $teams = Models\Teams::GetStandings();
                return $teams;
            }
        ],

        'shooters_2pt' => [
            'type' => Type::listOf($types['shooter']),
            'resolve' => function() {
                $players = Models\Players::GetShooters(false);
                return $players;
            }
        ],

        'shooters_3pt' => [
            'type' => Type::listOf($types['shooter']),
            'resolve' => function() {
                $players = Models\Players::GetShooters(true);
                return $players;
            }
        ],

        'playgrounds' => [
            'type' => Type::listOf($types['playground']),
            'resolve' => function($root, $args) {
                if(array_key_exists('id', $args)) {
                    $playgrounds = [ Models\Playground::find($args['id']) ];
                }
                else $playgrounds = Models\Playground::all();

                return $playgrounds;
            },
            'args' => [
                'id' => [ 'type' => Type::int() ]
            ]
        ],

        'matchDays' => [
            'type' => Type::listOf($types['date']),
            'resolve' => function() {
                $dates = Models\Games::GetListOfDates()->map(function($item) {
                    return [ 'timestamp' => $item ];
                });
                return $dates;
            }
        ]
    ],
]);


$schema = new Schema([
    'query' => $queries
]);