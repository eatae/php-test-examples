<?php

use UserStore\UserStore;

require_once (__DIR__.'/vendor/autoload.php');

$store = new UserStore();

var_dump($store);