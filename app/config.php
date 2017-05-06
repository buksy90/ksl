<?php
error_reporting(E_ALL);
ini_set('display_errors','On');

set_time_limit(1);
ini_set('memory_limit', '12M');

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$config['db']['driver']         = 'mysql';
$config['db']['host']           = getenv('IP');
$config['db']['username']       = getenv('C9_USER');
$config['db']['password']       = '';
$config['db']['database']       = 'c9';
$config['db']['collation']      = 'utf8_general_ci';
$config['db']['charset']        = 'utf8';
$config['db']['port']           = 3306;