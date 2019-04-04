<?php
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
//use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use \KSL\Models;

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
    ]
]);

$team = new ObjectType([
    'name' => 'Team',
    'description' => 'Represents team of players',
    'fields' => [
        'id' => [ 'type' => Type::int() ],
        'name' => [ 'type' => Type::string() ],
        'standing' => [ 'type' => Type::int(), 'description' => 'Position of team in standings' ],
        'score' => [ 
            'type' => Type::string(),
            'description' => 'Number of points team has scored and other teams has scored against it',
            'resolve' => function ($team) {
                return $team->points_scored . ':' . $team->points_allowed;
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
            'resolve' => function() {
                return Models\News::all();
            }
        ],

        'teams' => [
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
            'resolve' => function() {
                $players = Models\Playground::all();
                return $players;
            }
        ],

        'matchDays' => [
            'type' => Type::listOf($types['date']),
            'resolve' => function() {
                $dates = Models\Games::GetListOfDates()->map(function($item) {
                    return [ 'timestamp' => $item ];
                });
                return $dates;
            }
        ],
    ],
]);


$schema = new Schema([
    'query' => $queries
]);