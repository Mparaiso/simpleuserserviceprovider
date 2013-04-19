<?php

$autoload = require __DIR__ . "/../vendor/autoload.php";

$autoload->add("", __DIR__ . "/../app");
$autoload->add("", __DIR__ . "/../src");

$app = new App(array('debug' => true));
$app["http_cache"]->run();