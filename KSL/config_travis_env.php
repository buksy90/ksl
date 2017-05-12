<?php
//error_reporting(E_ALL);
//ini_set('display_errors','On');

//set_time_limit(1);
//ini_set('memory_limit', '12M');

define('TIMEZONE', 'Europe/Bratislava');
date_default_timezone_set(TIMEZONE);

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$config['db']['driver']         = 'mysql';
$config['db']['host']           = 'localhost';
$config['db']['username']       = 'travis';
$config['db']['password']       = '';
$config['db']['database']       = 'ksl';
$config['db']['collation']      = 'utf8_general_ci';
$config['db']['charset']        = 'utf8';
$config['db']['port']           = 3306;
$config['db']['timezone']       = '+02:00';