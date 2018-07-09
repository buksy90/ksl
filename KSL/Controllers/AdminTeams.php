<?php
namespace KSL\Controllers;

use \KSL\Models;
use \Illuminate\Database\Connection;

class AdminTeams extends BaseAdmin
{
    public function show($request, $response, $args) {
        $message = $messageClass = null;

        if(array_key_exists('action', $args)) {
            if($args['action'] === 'created') {
                $message        = 'Novinka bola vytvorená';
                $messageClass   = 'alert-success';
            }
            else if($args['action'] === 'updated') {
                $message        = 'Novinka bola upravená';
                $messageClass   = 'alert-success';
            }
            else if($args['action'] === 'deleted') {
                $message        = 'Novinka bola vymazaná';
                $messageClass   = 'alert-success';
            }
            else if($args['action'] === 'deletedFailed') {
                $message        = 'Novinku sa nepodarilo vymazať';
                $messageClass   = 'alert-danger';
            }
        }

        return $response->write( $this->ci->twig->render('adminTeams.tpl', [
            'navigationSwitch'  => 'admin',
            'message'           => $message,
            'messageClass'      => $messageClass,
            'activeTeams'       => Models\Teams::all(),
            'pendingTeams'      => Models\PendingTeams::all()
        ]));
    }

}