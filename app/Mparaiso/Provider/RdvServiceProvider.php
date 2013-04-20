<?php

namespace Mparaiso\Provider;

use Doctrine\ORM\Mapping\Driver\YamlDriver;
use Mparaiso\Rdv\Controller\DinnerController;
use Mparaiso\Rdv\Service\DinnerService;
use Mparaiso\Rdv\Service\RsvpService;
use Mparaiso\Rdv\Controller\RsvpController;
use Silex\Application;
use Silex\ServiceControllerResolver;
use Silex\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RouteCollection;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Config
 *
 * @author mark prades
 */
class RdvServiceProvider implements ServiceProviderInterface {

    public function boot(Application $app) {

        /** twig extension  */
        $app['twig.loader.filesystem'] = $app->extend("twig.loader.filesystem", function($loader, $app) {
                    $loader->addPath($app["mp.rdv.templates.path"]); // FR: ajouter le répertoire des templates FOS à TWIG
                    return $loader;
                }
        );
        /** routes extension  */
        $app['mp.route_loader']->add($app['mp.rdv.routes.type'], $app['mp.rdv.routes.path'], $app['mp.rdv.routes.prefix']);

        /** orm extension */
        $app["orm.chain_driver"] = $app->extend("orm.chain_driver", function($chain, $app) {
                    $chain->addDriver(new YamlDriver($app['mp.rdv.orm.resources.paths']), $app['mp.rdv.orm.namespace']);
                    return $chain;
                }
        );
    }

    public function register(Application $app) {
        $app["mp.rdv.templates.path"] = __DIR__ . "/../Rdv/Resources/views";
        $app['mp.rdv.templates.layout'] = "mp.rdv.layout.html.twig";
        $app['mp.rdv.routes.path'] = __DIR__ . "/../Rdv/Resources/routing/routes.yml";
        /**
         * TEMPLATES
         */
        $app['mp.rdv.templates.dinner.create'] = "rdv_dinner_create.html.twig";
        $app['mp.rdv.templates.dinner.read'] = "rdv_dinner_read.html.twig";
        $app['mp.rdv.templates.dinner.update'] = "rdv_dinner_update.html.twig";
        $app['mp.rdv.templates.dinner.delete'] = "rdv_dinner_delete.html.twig";
        $app['mp.rdv.routes.type'] = "yaml";
        $app['mp.rdv.routes.prefix'] = "/";
        $app['mp.rdv.orm.namespace'] = "Mparaiso\Rdv\Entity";
        $app['mp.rdv.entity.dinner'] = "Mparaiso\Rdv\Entity\BaseDinner";
        $app['mp.rdv.entity.rsvp'] = "Mparaiso\Rdv\Entity\BaseRsvp";

        $app['mp.rdv.form.dinner'] = "Mparaiso\Rdv\Form\DinnerType";

        $app['mp.rdv.orm.resources.paths'] = __DIR__ . '/../Rdv/Resources/doctrine/';
        $app['mp.rdv.orm.em'] = $app->share(function($app) {
                    return $app['orm.em'];
                });

        $app["mp.rdv.service.dinner"] = $app->share(function($app) {
                    return new DinnerService($app['mp.rdv.orm.em'], $app['mp.rdv.entity.dinner']);
                });
        $app['mp.rdv.service.rsvp'] = $app->share(function($app) {
                    return new RsvpService($app['mp.rdv.orm.em'], $app['mp.rdv.entity.rsvp']);
                });
        $app['mp.rdv.dinner_controller'] = $app->share(function($app) {
                    return new DinnerController($app['mp.rdv.service.dinner']);
                });

        $app['mp.rdv.controller.rsvp'] = $app->share(function($app) {
                    return new RsvpController($app['mp.rdv.service.rsvp']);
                });
    }

}
