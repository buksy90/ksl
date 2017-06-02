<?php
namespace KSL\Controllers;

use \KSL\Models;
use \Illuminate\Database\Connection;

class AdminNews extends BaseAdmin
{
    public function show($request, $response, $args) {
        $message = $messageClass = null;

        if(array_key_exists('action', $args)) {
            if($args['action'] === 'created') {
                $message        = 'Novinka bola vytvorená';
                $messageClass   = 'alert-success';
            }
        }

        return $response->write( $this->ci->twig->render('adminNews.tpl', [
            'navigationSwitch'  => 'admin',
            'message'           => $message,
            'messageClass'      => $messageClass,
            'news'              => Models\News::all()
        ]));
    }


    public function showNew($request, $response, $args) {
        $message = $messageClass = null;

        if(array_key_exists('action', $args)) {
            if($args['action'] === 'failed') {
                $message        = 'Nepodarilo sa vytvoriť novinku';
                $messageClass   = 'alert-danger';
            }
        }

        return $response->write( $this->ci->twig->render('adminNews_new.tpl', [
            'navigationSwitch'  => 'admin',
            'message'           => $message,
            'messageClass'      => $messageClass,
            'title'             => array_key_exists('title', $args) ? $args['title'] : null,
            'text'              => array_key_exists('text', $args) ? $args['text'] : null
        ]));
    }


    public function showCreate($request, $response, $args) {
        $parameters = $request->getParsedBody();

        $news           = new Models\News();
        $news->title    = $parameters['title'];
        $news->text     = $parameters['text'];

        if($news->save()) {
            $this->show($request, $response, ['action' => 'created']);
        } 
        else {
            $this->showNew($request, $response, [
                'action'    => 'failed',
                'title'     => $parameters['title'], 
                'text'      => $parameters['text']
            ]);
        }
    }
}