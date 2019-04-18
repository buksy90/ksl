<?php
$app = require('init.php');
$app->post('/', '\KSL\Controllers\Api:show');
$app->options('/', '\KSL\Controllers\Api:showOptions');
$app->run();