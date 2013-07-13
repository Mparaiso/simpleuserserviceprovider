<?php

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

$autoload = require __DIR__ . "/../vendor/autoload.php";
$debug =  getenv("RSVP_ENV") === 'development' ? TRUE : FALSE;
$app = new App(array('debug' =>$debug));
$app->run();