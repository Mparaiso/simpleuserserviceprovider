<?php

namespace Mparaiso\Provider;

use Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\DriverChain;
use Doctrine\ORM\Mapping\Driver\YamlDriver;
use Mparaiso\User\Command\CreateRoleCommand;
use Mparaiso\User\Controller\ProfileController;
use Mparaiso\User\Controller\RegistrationController;
use Mparaiso\User\Controller\SecurityController;
use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ServiceProviderInterface;

class SimpleUserServiceProvider implements ServiceProviderInterface, ControllerProviderInterface {

    function register(Application $app) {
        $app['mp.user.controllers'] = $this;
        /* UserRepository */
        $app['mp.user.user_service'] = $app->share(function($app) {
                    return new $app['mp.user.user_service.class'](
                            $app['mp.user.em'], $app['mp.user.user.class'], $app['mp.user.role.class']
                    );
                });
        /* RoleRepository */
        $app['mp.user.role_service'] = $app->share(function($app) {
                    return $app['mp.user.em']->getRepository($app['mp.user.role.class']);
                });
        $app['mp.user.security_controller'] = $app->share(function() {
                    return new SecurityController;
                });
        $app['mp.user.registration_controller'] = $app->share(function() {
                    return new RegistrationController;
                });
        $app['mp.user.profile_controller'] = $app->share(function() {
                    return new ProfileController;
                });
        /** EntityManager * */
        $app['mp.user.em'] = $app->share(function($app) {
                    return $app['orm.em'];
                });
        $app["mp.user.manager_registry"] = $app->share(function($app) {
                    return $app['orm.manager_registry'];
                });
        // @return Symfony\Component\Security\Core\User\UserProviderInterface;
        $app['mp.user.user_provider'] = $app->share(function($app) {
                    $service = new $app['mp.user.user_provider.class'](
                            $app['mp.user.manager_registry'], $app['mp.user.user.class'], $app['mp.user.user_provider.property']
                    );
                    return $service;
                });

        /** install commands for the console tool */
        $app['mp.user.console'] = function($app) {
                    return $app['console'];
                };
        $app['mp.user.boot_commands'] = $app->protect(function()use($app) {
                    $app['mp.user.console']->add(new CreateRoleCommand);
                });
        $app['mp.user.user_provider.class'] = "Symfony\Bridge\Doctrine\Security\User\EntityUserProvider";
        $app['mp.user.user_provider.property'] = 'username';
        $app['mp.user.user_provider.manager_name'] = null;

        $app['mp.user.user.class'] = 'Mparaiso\User\Entity\User';
        $app['mp.user.role.class'] = "Mparaiso\User\Entity\Role";
        $app['mp.user.role_service.class'] = "Mparaiso\User\Repository\RoleRepository";
        $app['mp.user.user_service.class'] = "Mparaiso\User\Service\UserService";
        $app['mp.user.registration.type'] = "Mparaiso\User\Form\RegistrationType";
        $app['mp.user.registration.model'] = $app['mp.user.user.class'];

        $app['mp.user.profile.type'] = "Mparaiso\User\Form\ProfileType";
        $app['mp.user.profile.model'] = $app['mp.user.user.class'];

        $app['mp.user.login_template'] = "mp.user.login.html.twig";
        $app['mp.user.register_template'] = "mp.user.register.html.twig";

        $app['mp.user.route.login'] = "/login";
        $app['mp.user.route.login.check'] = "/login-check";
        $app['mp.user.route.register'] = "/register";
        $app["mp.user.route.profile.index"] = "/profile";
        $app['mp.user.route.logout'] = "/logout";
        $app['mp.user.template.layout'] = "mp.user.layout.html.twig";
        $app['mp.user.template.profile'] = "mp.user.profile.html.twig";
        $app['mp.user.template.flash'] = "mp.user.flash.html.twig";
        $app['mp.user.template.status'] = "mp.user.status.html.twig";
        $app['mp.user.template_path'] = __DIR__ . "/../User/Resources/views";

        $app['mp.user.make_salt'] = $app->protect(function() {
                    return uniqid();
                });
    }

    function boot(Application $app) {
        /** twig * */
        $app['twig.loader.filesystem'] = $app->extend("twig.loader.filesystem", function($loader, $app) {
                    $loader->addPath($app['mp.user.template_path']); // FR: ajouter le répertoire des templates FOS à TWIG
                    return $loader;
                }
        );
        /** install entities * */
        $app['orm.chain_driver'] = $app->share(
                $app->extend("orm.chain_driver", function(MappingDriverChain $chain, $app) {
                            $dir = __DIR__ . "/../User/Resources/doctrine/";
                            $chain->addDriver(new YamlDriver($dir), "Mparaiso\User\Entity");
                            return $chain;
                        }
                )
        );
    }

    public function connect(Application $app) {
        $controllers = $app['controllers_factory'];
        $controllers->match($app['mp.user.route.login.check'], "mp.user.security_controller:loginCheck")
                ->bind('mp.user.route.login.check');
        $controllers->match($app['mp.user.route.login'], "mp.user.security_controller:login")
                ->bind('mp.user.route.login');
        $controllers->match($app['mp.user.route.logout'], "mp.user.security_controller:logout")
                ->bind("mp.user.route.logout");
        $controllers->match($app["mp.user.route.profile.index"], "mp.user.profile_controller:index")
                ->bind("mp.user.route.profile.index");
        $controllers->match($app["mp.user.route.register"], "mp.user.registration_controller:register")
                ->bind('mp.user.route.register');
        return $controllers;
    }

}

