<?php
require 'init.php';

session_start();

try {
    $user   = new \KSL\Models\User();
    $user->Logout();

    $path   = 'http://localhost:3000/';
    header('Location: '.$path);
}
catch(Exception $e) {
    die($e->getMessage());
}