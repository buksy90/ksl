<?php
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
//use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use \KSL\Models;


$dateType = new ObjectType([
    'name' => 'Date',
    'fields' => [
        'timestamp' => [ 'type' => Type::int() ],
        'datetime' => [ 
            'type' => Type::string(),
            'description' => 'Date and time format that should be parsable using javascripts Date.parse()',
            'resolve' => function($date) { 
                return date('c', $date['timestamp']); 
            }
        ],
        'datetime_human' => [
            'type' => Type::string(),
            'description' => 'Date and time format that is easily read by human',
            'resolve' => function($date) { return date('r', $date['timestamp']); }
        ],
        'date' => [
            'type' => Type::string(),
            'description' => 'Date of match',
            'resolve' => function($date) { return date('Y-m-d', $date['timestamp']); }
        ],
    ]
]);

$articleType = new ObjectType([
    'name' => 'Article',
    'fields' => [
        'id' => [ 'type' => Type::int() ],
        'title' => [ 'type' => Type::string() ],
        'text' => [ 'type' => Type::string() ],
        'date' => [ 'type' => $dateType ]
    ]
]);

$playgroundType = new ObjectType([
    'name' => 'Playground',
    'fields' => [
        'id' => [ 'type' => Type::int() ],
        'name' => [ 'type' => Type::string() ],
        'address' => [ 'type' => Type::string() ],
        'district' => [ 'type' => Type::string() ],
        'latitude' => [ 'type' => Type::float() ],
        'longitude' => [ 'type' => Type::float() ],
    ]
]);

// teamType is defined later but must be 
// declared here because player references to it
$teamType = null;

$playerType = New ObjectType([
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
            'type' => &$teamType,
            'resolve' => function($root, $args) {
                $roster = Models\Roster::select('team_id')
                    ->where('player_id', $root->id)
                    ->orderBy('season_id', 'desc')
                    ->first();

                $team = Models\Teams::find($roster->team_id);

                return $team;
            }
        ],
        'matches_count' => [
            'type' => Type::int(),
            'resolve' => function($root, $args) {
                $player = Models\Players::find($root->id);

                return $player->GetGamesPlayedCount();
            }
        ],
        'made_2pt' => [
            'type' => Type::int(),
            'resolve' => function($root, $args) {
                $player = Models\Players::find($root->id);

                return $player->GetPointsSum();
            }
        ],
        'made_3pt' => [
            'type' => Type::int(),
            'resolve' => function($root, $args) {
                $player = Models\Players::find($root->id);

                return $player->GetPointsSum(true);
            }
        ],
    ]
]);


$teamType = new ObjectType([
    'name' => 'Team',
    'description' => 'Represents team of players',
    'fields' => [
        'id' => [ 'type' => Type::int() ],
        'name' => [ 'type' => Type::string() ],
        'short' => [ 'type' => Type::string() ],
        'captain' => [ 
            'type' => $playerType, 
            'resolve' => function($root, $args) {
                $team = Models\Teams::select('captain_id')->where('id', $root->id)->first();
                if($team->captain_id) {
                    $captain = Models\Players::find($team->captain_id);
                    return $captain;
                }
                
                return null;
            }
        ],
        'standing' => [ 
            'type' => Type::int(), 
            'description' => 'Position of team in standings',
            'resolve' => function($root, $args) {
                return Models\Teams::TeamStandingOrder($root->id);
            }
        ],
        'score' => [ 
            'type' => Type::string(),
            'description' => 'Number of points team has scored and other teams has scored against it',
            'resolve' => function ($root, $args) {
                return Models\Teams::GetStandings($root->id)->points_scored . ':' . Models\Teams::GetStandings($root->id)->points_allowed;
            }
        ],
        'current_roster' => [ 
            'type' => Type::listOf($playerType),
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
        'games_played' => [ 
            'type' => Type::int(), 
            'resolve' => function($root, $args) {
                $won =  Models\Games::WonBy($root->id)->count();
                $lost = Models\Games::LostBy($root->id)->count();

                return $won + $lost;
            }
        ],
        'games_won' => [ 
            'type' => Type::int(),
            'resolve' => function($root, $args) {
                return Models\Games::WonBy($root->id)->count();
            }
        ],
        'games_lost' => [ 
            'type' => Type::int(),
            'resolve' => function($root, $args) {
                return Models\Games::LostBy($root->id)->count();
            }
        ],
        'points' => [ 
            'type' => Type::int(), 
            'description' => 'Number of points team has in table for wins',
            'resolve' => function($root, $args) {
                return Models\Teams::GetStandings($root->id)->points;
            }
        ],
        'points_scored' => [ 
            'type' => Type::int(),
            'resolve' => function($root, $args) {
                return Models\Teams::GetStandings($root->id)->points_scored;
            }
        ],
        'points_allowed' => [ 
            'type' => Type::int(),
            'resolve' => function($root, $args) {
                return Models\Teams::GetStandings($root->id)->points_allowed;
            }
        ],
        'success_rate' => [ 
            'type' => Type::int(),
            'resolve' => function($root, $args) {
                return (int) Models\Teams::GetStandings($root->id)->success_rate;
            }
        ]
    ]
]);

$shooterType = new ObjectType([
    'name' => 'Shooter',
    'fields' => [
        'standing' => [ 'type' => Type::int() ],
        'player' => [ 'type' => $playerType ],
        'team' => [ 'type' => $teamType ],
        'games' => [ 'type' => Type::int() ],
        'points' => [ 'type' => Type::int() ],
        'average' => [ 'type' => Type::int() ],
    ]
]);

$matchType = new ObjectType([
    'name' => 'Match',
    'fields' => [
        'date' => [ 
            'type' => $dateType,
            'resolve' => function($match, $args) {
                return [ 'timestamp' => strtotime($match->date) ];
            }
         ],
        'home_team' => [ 
            'type' => $teamType,
            'resolve' => function($match) { 
                if(is_numeric($match->hometeam)) {
                    return Models\Teams::find($match->hometeam);
                }
                else return $match->hometeam;
            }
        ],
        'away_team' => [ 
            'type' => $teamType,
            'resolve' => function($match) { 
                if(is_numeric($match->awayteam)) {
                    return Models\Teams::find($match->awayteam);
                }
                else return $match->awayteam;
            }
        ],
        'playground' => [ 
            'type' => $playgroundType,
            'resolve' => function($match) {
                return Models\Playground::find($match->playground_id);
            }
        ],
        'home_score' => [ 
            'type' => Type::int(),
            'description' => 'number of points home team has scored',
            'resolve' => function($match) { return $match->home_score == null ? null : $match->home_score; } ],
        'away_score' => [ 
            'type' => Type::int(),
            'description' => 'number of points away team has scored',
            'resolve' => function($match) { return $match->away_score == null ? null : $match->away_score; } ],
        'played' => [
            'type' => Type::boolean(),
            'description' => 'Has the match been played?',
            'resolve' => function($match) {
                return $match->home_score != null && $match->away_score != null && strtotime($match->date) < time();
            }
        ]
    ]
]);

$userType = new ObjectType([
    'name' => 'User',
    'fields' => [
        'id' => [ 'type' => Type::int() ],
        //'identifier' => [ 'type' => Type::string() ],
        //'email' => [ 'type' => Type::string() ],
        'name' => [ 
            'type' => Type::string(),
            'resolve' => function($root) {
                return $root->firstName;
            }
        ],
        'surname' => [ 
            'type' => Type::string(),
            'resolve' => function($root) {
                return $root->lastName;
            }
        ],
        'avatar_url' => [ 
            'type' => Type::string(),
            'resolve' => function($root) {
                return $root->avatarUrl;
            }
        ],
        'roles' => [
            'type' => Type::listOf(Type::string()),
            'resolve' => function($user) {
                $roles = [ 'user' ];
                if(Models\UserPermissions::HasPermission($user->id, 'admin')) array_push($roles, 'admin');

                return $roles;
            }
        ]
    ]
]);

$types = [
    'article' => $articleType,
    'team' => $teamType,
    'player' => $playerType,
    'shooter' => $shooterType,
    'playground' => $playgroundType,
    'date' => $dateType,
    'match' => $matchType,
    'user' => $userType
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
            'type' => Type::listOf($teamType),
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
            'type' => Type::listOf($playerType),
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
            'type' => Type::listOf($teamType),
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
            'type' => Type::listOf($dateType),
            'resolve' => function() {
                $dates = Models\Games::GetListOfDates()->map(function($item) {
                    return [ 'timestamp' => $item ];
                });
                return $dates;
            }
        ],

        'matches' => [
            'type' => Type::listOf($matchType),
            'resolve' => function($root, $args) {
                if(array_key_exists('id', $args)) {
                    $matches = [ Models\Games::find($args['id']) ];
                }
                else if(array_key_exists('team_id', $args)) {
                    $matches = Models\Games::playedBy($args['team_id'])->get();
                }
                else $matches = Models\Games::all();
                
                if(array_key_exists('date', $args)) {
                    $matches = $matches->filter(function($match) use ($args) {
                        $matchDate = explode(' ', $match->date);
                        return $matchDate[0] == $args['date'];
                    });
                }

                return $matches;
            },
            'args' => [
                'id' => [ 'type' => Type::int() ],
                'team_id' => [
                    'type' => Type::int(),
                    'description' => 'Id of team whose matches should be returned'
                ],
                'date' => [
                    'type' => Type::string(),
                    'descirption' => 'Date filter, should be in YYYY-MM-DD format, same information returns matchDays query under date property'
                ]
            ]   
        ],

        'user' => [
            'type' => $userType,
            'resolve' => function($root, $args) {                
               return Models\User::GetUser();
            }
        ]
    ]
]);


$schema = new Schema([
    'query' => $queries
]);

return $schema;