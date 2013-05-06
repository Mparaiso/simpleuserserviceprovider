<?php

use Entity\Rsvp;
use Mparaiso\Provider\ConsoleServiceProvider;
use Mparaiso\Provider\DoctrineORMServiceProvider;
use Mparaiso\Provider\RdvServiceProvider;
use Mparaiso\Provider\RouteConfigServiceProvider;
use Mparaiso\Provider\SimpleUserServiceProvider;
use Mparaiso\Rdv\Event\DinnerEvents;
use Mparaiso\Rdv\Event\RsvpEvents;
use Silex\Application;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\HttpCacheServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\SecurityServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\SerializerServiceProvider;
use Silex\ServiceProviderInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\Request;

class Config implements ServiceProviderInterface
{

    public function boot(Application $app)
    {
        $app["dispatcher"]->addListener(DinnerEvents::BEFORE_CREATE, $app['before_dinner_create']);
        $app['dispatcher']->addListener(RsvpEvents::BEFORE_CREATE, $app["before_rsvp_create"]);
        $app["dispatcher"]->addListener(RsvpEvents::BEFORE_DELETE, $app["before_rsvp_delete"]);
    }

    public function register(Application $app)
    {
        $app->register(new SerializerServiceProvider);
        $app->register(new DoctrineORMServiceProvider, array(
            "orm.proxy_dir"      => __DIR__ . '/Proxy/',
            "orm.driver.configs" => array(
                "default" => array(
                    "type"      => "yaml",
                    "paths"     => array(__DIR__ . "/Resources/doctrine/"),
                    "namespace" => "Entity"
                )
            )
        ));
        $app->register(new DoctrineServiceProvider, array(
            "db.options" => array(
                "driver"   => getenv('RSVP_DRIVER'),
                "path"     => getenv('RSVP_PATH'),
                "dbname"   => getenv('RSVP_DBNAME'),
                "host"     => getenv('RSVP_HOST'),
                "username" => getenv('RSVP_USERNAME'),
                "password" => getenv('RSVP_PASSWORD')
            )
        ));
        $app->register(new MonologServiceProvider, array(
            "monolog.logfile" => __DIR__ . "/../temp/" . date("Y-m-d") . ".txt",
        ));
        $app->register(new ConsoleServiceProvider);
        $app->register(new UrlGeneratorServiceProvider);
        $app->register(new FormServiceProvider);
        $app->register(new SessionServiceProvider);
        $app->register(new ValidatorServiceProvider);

        $app->register(new ServiceControllerServiceProvider);
        $app->register(new TwigServiceProvider, array(
            "twig.path"    => array(__DIR__ . '/Resources/views/'),
            'twig.options' => array(
                'cache' => __DIR__ . '/../temp/Cache')));

        $app->register(new HttpCacheServiceProvider, array(
            "http_cache.cache_dir" => __DIR__ . "/../temp/http_cache/",
        ));


        $app->register(new TranslationServiceProvider, array(
                "locale" => 'fr'
            )
        );
        $app->register(new RouteConfigServiceProvider, array(
            'mp.route_loader.cache' => __DIR__ . "/../temp/routing",
            # "mp.route_loader.debug" => false,
        ));


        $app->register(new SimpleUserServiceProvider, array(
            'mp.user.template.layout'    => function ($app) {
                return $app['mp.rdv.templates.layout'];
            }, 'mp.user.user.class'      => 'Entity\User',
            "mp.user.form.profile.model" => 'Entity\User'
        ));


        $app->register(new RdvServiceProvider, array(
            "mp.rdv.templates.layout" => "layout.html.twig",
            'mp.rdv.entity.dinner'    => 'Entity\Dinner',
            "mp.rdv.entity.rsvp"      => 'Entity\Rsvp',
            "mp.rdv.form.dinner"      => 'Form\DinnerType',
            'mp.rdv.routes.path'      => __DIR__ . "/Resources/routing/mp_rdv_routes.yml",
        ));
        if (!isset($app['no_security']) || $app['no_security'] == FALSE) {
            $app->register(new SecurityServiceProvider, array(
                    "security.firewalls"    => function ($app) {
                        return array(
                            "secured" => array(
                                "pattern"   => "^/",
                                "anonymous" => TRUE,
                                "form"      => array(
                                    "login_path"                     => "/login",
                                    "check_path"                     => "/login-check",
                                    "always_use_default_target_path" => FALSE,
                                    // "default_target_path" => null,
                                ),
                                "logout"    => array(
                                    "logout_path"        => "/logout",
                                    "target"             => "/",
                                    "invalidate_session" => TRUE,
                                    "delete_cookies"     => TRUE
                                ),
                                "users"     => $app['mp.user.user_provider']
                            )
                        );
                    },
                    "security.access_rules" => array(
                        array("/login-check", "IS_AUTHENTICATED_FULLY"),
                        array("/profile", "IS_AUTHENTICATED_FULLY"),
                        array('/logout', "IS_AUTHENTICATED_FULLY"),
                        array("^/dinner/create", "IS_AUTHENTICATED_FULLY"),
                        array("^/dinner/edit", "IS_AUTHENTICATED_FULLY"),
                    )
                )
            );
        }
        $app['before_rsvp_create'] = $app->protect(function (GenericEvent $event) use ($app) {
                $rsvp = $event->getSubject();
                $dinner = $event->getArgument("dinner");
                $user = $app["security"]->getToken()->getUser();
                if (!$dinner->isUserRegistered($user)) {
                    $rsvp->setAttendeeName($user->getUsername());
                    $rsvp->setUser($user);
                } else {
                    $app->abort(500, 'user already registered to the event!');
                }
            }
        );
        $app['before_rsvp_delete'] = $app->protect(function (GenericEvent $event) use ($app) {
                $rsvp = $event->getSubject();
                $dinner = $event->getArgument("dinner");
                $attendeeName = $event->getArgument("attendeeName");
                $user = $app["security"]->getToken()->getUser();
                if ($user->getUsername() != $attendeeName) {
                    $app->abort(500, 'user cant unregister this attendee  ');
                } elseif (!$dinner->isUserRegistered($user)) {
                    $app->abort(500, 'user is not registered to the event!');
                } elseif ($dinner->getHost() == $user) {
                    $app->abort(500, 'you cant unregistered from your own event!');
                }
            }
        );
        $app['before_dinner_create'] = $app->protect(function ($event) use ($app) {
            // FR : ajoute un utilisateur qui sera propriétaire du dinner , ainsi qu'un rsvp
            $app['logger']->info("BEFORE CREATING A DINNER");
            $dinner = $event->getSubject();
            $user = $app['security']->getToken()->getUser();
            $dinner->setHost($user);
            $dinner->setHostedBy($user->getUsername());
            $rsvp = new Rsvp();
            $rsvp->setUser($user);
            $rsvp->setAttendeeName($user->getUsername());
            $rsvp->setDinner($dinner);
            $dinner->addRsvp($rsvp);
        });
    }

    /**
     * FR : si utilisateur n'est pas propriétaire du dinner , abort !
     * EN : if user doesnt own dinner , abort !
     * @param Request $req
     * @param Application $app
     */
    static function beforeRdvDinnerUpdate(Request $req, Application $app)
    {
        $user = $app["security"]->getToken()->getUser();
        $dinnerId = $req->attributes->get("id");
        $dinner = $app["mp.rdv.service.dinner"]->find($dinnerId);
        if ($dinner->getHost() != $user) {
            $app->abort(500, "You cant access that resource !");
        }
    }

}