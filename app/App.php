<?php

use Mparaiso\Provider\ConsoleServiceProvider;
use Mparaiso\Provider\DoctrineORMServiceProvider;
use Mparaiso\Provider\RdvServiceProvider;
use Mparaiso\Provider\RouteConfigServiceProvider;
use Mparaiso\Provider\SimpleUserServiceProvider;
use Silex\Application;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\HttpCacheServiceProvider;
use Silex\Provider\SecurityServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\ValidatorServiceProvider;

class App extends Application {

    function __construct(array $values = array()) {
        parent::__construct($values);
        $this->register(new Config);
    }

}

