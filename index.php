<?php
require __DIR__ . '/vendor/autoload.php';
require './private/bridge.php';

use DevCoder\DotEnv;

(new DotEnv( './.env'))->load();


session_start();

$myApp = new App();
