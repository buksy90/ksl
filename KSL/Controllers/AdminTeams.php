<?php
namespace KSL\Controllers;

use \KSL\Models;
use \Illuminate\Database\Connection;

class AdminTeams extends BaseAdmin
{
    public function show($request, $response, $args) {
        $message = $messageClass = null;

        if(array_key_exists('action', $args)) {
            if($args['action'] === 'updated') {
                $message        = 'Tím bol upravený';
                $messageClass   = 'alert-success';
            }
            else if($args['action'] === 'failed') {
                $message        = 'Vyskytla sa chyba';
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


    public function showEdit($request, $response, $args) {
        $message = $messageClass = null;

        return $response->write( $this->ci->twig->render('adminTeams_edit.tpl', [
            'navigationSwitch'  => 'admin',
            'message'           => $message,
            'messageClass'      => $messageClass,
            'team'              => Models\Teams::find((int)$args['id'])
        ]));
    }

    public function showUpdate($request, $response, $args) {
        $parameters = $request->getParsedBody();

        $team           = Models\Teams::find($parameters['id']);
        $team->name     = $parameters['name'];
        $team->short    = $parameters['short'];

        if($team->save()) {
            $this->show($request, $response, ['action' => 'updated']);
        } 
        else {
            $this->showEdit($request, $response, [
                'action'    => 'failed',
                'id'        => $parameters['id']
            ]);
        }
    }
}