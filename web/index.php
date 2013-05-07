<?php

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

$autoload = require __DIR__ . "/../vendor/autoload.php";
$autoload->add("", __DIR__ . "/../app");
$autoload->add("", __DIR__ . "/../src");
$app = new App(array('debug' => getenv("RSVP_ENV") === 'development' ? TRUE : FALSE));
$app->match('/info', function () {
    phpinfo();
})->before(function (Request $req) use ($app) {
    if ($app['debug'] === FALSE) {
        return new RedirectResponse($req->getBaseUrl());
    }
});
$app->run();