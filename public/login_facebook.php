<?php
require 'init.php';

session_start();

try {
    $hybridauthConfig = $container->get('settings')["hybridauth"];
    $hybridauthConfig['callback']  = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/login_facebook.php';

    $hybridauth     = new \Hybridauth\Hybridauth($hybridauthConfig);
    $adapter        = $hybridauth->authenticate('Facebook');
    $isConnected    = $adapter->isConnected();
    $userProfile    = $adapter->getUserProfile();

    if(empty($userProfile)) die('Error #1');

    $identifier = $userProfile->identifier;
    
    if(\KSL\Models\User::IdentifierExists($identifier)) {
        $user   = new \KSL\Models\User();
        $user->Login($identifier);

        $path   = 'http://localhost:3000/';
    }
    else {
        $user   = \KSL\Models\User::Register($identifier, $userProfile->email, $userProfile->firstName, $userProfile->lastName, $userProfile->photoURL);
        $user->Login($identifier);
        
        $path   = 'http://localhost:3000/welcome';
    }

    header('Location: '.$path);
}
catch(Exception $e) {
    die($e->getMessage());
}