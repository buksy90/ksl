<?php
namespace KSL\Controllers;

use \KSL\Models;
use \Illuminate\Database\Connection;

class AdminImport extends BaseAdmin
{
    public function show($request, $response, $args) {
        $message    = $messageClass = null;
        $db         = $this->ci->get("connection");
        
        $base       = new Models\Base();
        $tables     = [
            'hráči'     => [
                'old'   => $db->table("hraci")->count(),
                'new'   => Models\Players::count(),
                'name'  => (new Models\Players())->GetTableName(),
                'table' => 'hraci'
            ],
            'domáci'    => [
                'old'   => $db->table("domaci")->count(),
                'new'   => Models\Teams::count(),
                'name'  => (new Models\Teams())->GetTableName(),
                'table' => 'domaci'
            ],
            'hostia'    => [
                'old'   => $db->table("hostia")->count(),
                'new'  => Models\Teams::count(),
                'name' => (new Models\Teams())->GetTableName(),
                'table' => 'hostia'
            ],
            'družstva'  => [
                'old'   => $db->table("druzstva")->count(),
                'new'   => Models\Teams::count(),
                'name'  => (new Models\Teams())->GetTableName(),
                'table' => 'druzstva'
            ],
            'ihriska'   => [
                'old'   => $db->table("ihriska")->count(),
                'new'   => Models\Playground::count(),
                'name'  => (new Models\Playground())->GetTableName(),
                'table' => 'ihriska'
            ],
            'liga'      => [
                'old'   => $db->table("liga")->count(),
                'new'   => Models\Games::count(),
                'name'  => (new Models\Games())->GetTableName(),
                'table' => 'liga'
            ],
        ];

        
        if(array_key_exists('action', $args)) {
            if($args['action'] === 'importUnsupported') {
                $message        = 'Import vybranej tabuľky nie je podporovaný';
                $messageClass   = 'alert-warning';
            }
            else if($args['action'] === 'importSuccessful') {
                $message        = 'Import bol úspešný';
                $messageClass   = 'alert-success';
            }
            else if($args['action'] === 'importUnsupported') {
                $message        = 'Vyskytla sa chyba pri importe';
                $messageClass   = 'alert-danger';
            }
            else  if($args['action'] === 'error') {
                $message        = $args['message'];
                $messageClass   = 'alert-danger';
            }
        }

        return $response->write( $this->ci->twig->render('adminImport.tpl', [
            'navigationSwitch'  => 'admin',
            'message'           => $message,
            'messageClass'      => $messageClass,
            'tables'            => $tables
        ]));
    }


     public function showImport($request, $response, $args) {
        $db             = $this->ci->get("connection");

        switch($args['target']) {
            case 'druzstva': {
                if($db->table("v2_teams")->count() != 0) {
                    return $this->show($request, $response, ['action' => 'error', 'message' => 'Tabuľka už obsahuje dáta']);
                }

                return $db->statement('INSERT INTO `v2_teams` (`name`, `short`, `captain_id`) SELECT `nazov`, `znak`, 0 FROM `druzstva`;')
                    ? $this->show($request, $response, ['action' => 'importSuccessful'])
                    : $this->show($request, $response, ['action' => 'importError']);
            } break;



            case 'hraci': {
                if($db->table("v2_players")->count() != 0) {
                    return $this->show($request, $response, ['action' => 'error', 'message' => 'Tabuľka už obsahuje dáta']);
                }

                $importPlayers = $db->statement('INSERT INTO `v2_players` (`name`, `surname`, `facebook`, `nick`, `seo`, `birthdate`, `jersey`, `sex`, `category`) 
                    SELECT `meno`, `priezvisko`, "", "", "", DATE_SUB(NOW(), INTERVAL `vek` YEAR), `cdresu`, if(`pohlavie`="MUŽ", "male", "female"), `kategoria`
                    FROM `hraci`;');

                if(!$importPlayers) 
                    return $this->show($request, $response, ['action' => 'error', 'message' => 'Vyskytla sa chyba pri importovaní hráčov']);


                $season         = Models\Season::GetActual();
                if($season instanceof Models\Season === false) return $this->show($request, $response, ['action' => 'error', 'message' => 'Vyskytla sa chyba pri importe súpisiek, nie je definovaná aktuálna sezóna']);

                $importRosters  = $db->statement('INSERT INTO `v2_roster` (`team_id`, `player_id`, `season_id`) 
                    SELECT t2.`id`, p2.`id`, "'.$season->id.'"
                    FROM `hraci` AS `p1`
                    JOIN `v2_players` AS `p2` ON p1.`meno` = p2.`name` AND p1.`priezvisko` = p2.`surname`
                    JOIN `druzstva` AS `t1` ON t1.`pc` = p1.`druzstv`
                    JOIN `v2_teams` AS `t2` ON t2.`name` = t1.`nazov`;');

                return $importRosters
                    ? $this->show($request, $response, ['action' => 'importSuccessful'])
                    : $this->show($request, $response, ['action' => 'importError']);
            } break;



            case 'liga': {
                if($db->table("v2_games")->count() != 0) {
                    return $this->show($request, $response, ['action' => 'error', 'message' => 'Tabuľka už obsahuje dáta']);
                }

                $season         = Models\Season::GetActual();

                return $db->statement('INSERT INTO `v2_games` (`season_id`, `hometeam`, `awayteam`, `date`, `playground_id`, `referee`, `won`, `home_score`, `away_score`) 
                    SELECT "'.$season->id.'", t2.`id`, t4.`id`, DATE_FORMAT(ADDTIME(from_unixtime(g1.`datum`), g1.`cas`), "%Y-%m-%d %H:%i"), 
                    g1.`ihrisko`, 1, IF(g1.`hrany`="N", null, IF(g1.`vysl1`>g1.`vysl2`, "HOME", "AWAY")), g1.`vysl1`, g1.`vysl2`
                    FROM `liga` AS `g1`

                    JOIN `druzstva` AS `t1` ON t1.`pc` = g1.`domaci`
                    JOIN `v2_teams` AS `t2` ON t2.`name` = t1.`nazov`

                    JOIN `druzstva` AS `t3` ON t3.`pc` = g1.`hostia`
                    JOIN `v2_teams` AS `t4` ON t4.`name` = t3.`nazov`')
                    ? $this->show($request, $response, ['action' => 'importSuccessful'])
                    : $this->show($request, $response, ['action' => 'importError']);
            } break;



            case 'ihriska': {
                if($db->table("v2_playground")->count() != 0) {
                    return $this->show($request, $response, ['action' => 'error', 'message' => 'Tabuľka už obsahuje dáta']);
                }

                return $db->statement('INSERT INTO `v2_playground` (`name`, `link`, `address`, `district`, `latitude`, `longitude`)  SELECT i1.`nazov`, "", "", i1.`mcast`, 0, 0 FROM `ihriska` AS `i1`')
                    ? $this->show($request, $response, ['action' => 'importSuccessful'])
                    : $this->show($request, $response, ['action' => 'importError']);
            }



            default: {
                return $this->show($request, $response, ['action' => 'importUnsupported']);
            }
        }
    }
}