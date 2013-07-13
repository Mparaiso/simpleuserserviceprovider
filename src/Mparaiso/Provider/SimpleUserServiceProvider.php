<?php

namespace Mparaiso\Provider;

use Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain;
use Doctrine\ORM\Mapping\Driver\YamlDriver;
use Mparaiso\User\Command\CreateRoleCommand;
use Mparaiso\User\Controller\ProfileController;
use Mparaiso\User\Controller\RegistrationController;
use Mparaiso\User\Controller\SecurityController;
use Silex\Application;
use Silex\ServiceProviderInterface;

class SimpleUserServiceProvider implements ServiceProviderInterface
{

    function register(Application $app)
    {
        $app['mp.user.service.user'] = $app->share(function ($app) {
            return new $app['mp.user.service.user.class'](
                $app['mp.user.om'], $app['mp.user.user.class'], $app['mp.user.role.class']
            );
        });
        /* RoleRepository */
        $app['mp.user.role_service'] = $app->share(function ($app) {
            return $app['mp.user.om']->getRepository($app['mp.user.role.class']);
        });
        $app['mp.user.controller.security'] = $app->share(function () {
            return new SecurityController;
        });
        $app['mp.user.controller.registration'] = $app->share(function ($app) {
            return new RegistrationController($app['mp.user.service.user']);
        });
        $app['mp.user.controller.profile'] = $app->share(function ($app) {
            return new ProfileController($app['mp.user.service.user']);
        });
        /** ObjectManager * */
        $app['mp.user.om'] = $app->share(function ($app) {
            return $app['orm.em'];
        });
        $app["mp.user.manager_registry"] = $app->share(function ($app) {
            return $app['orm.manager_registry'];
        });
        // @return Symfony\Component\Security\Core\User\UserProviderInterface;
        $app['mp.user.user_provider'] = $app->share(function ($app) {
            $service = new $app['mp.user.user_provider.class'](
                $app['mp.user.manager_registry'], $app['mp.user.user.class'], $app['mp.user.user_provider.property']
            );
            return $service;
        });

        /** install commands for the console tool */
        $app['mp.user.console'] = function ($app) {
            return $app['console'];
        };
        $app['mp.user.boot_commands'] = $app->protect(function () use ($app) {
            $app['mp.user.console']->add(new CreateRoleCommand);
        });
        $app['mp.user.user_provider.class'] = 'Symfony\Bridge\Doctrine\Security\User\EntityUserProvider';
        $app['mp.user.user_provider.property'] = 'username';
        $app['mp.user.user_provider.manager_name'] = NULL;

        $app['mp.user.user.class'] = 'Mparaiso\User\Entity\User';
        $app['mp.user.role.class'] = 'Mparaiso\User\Entity\Role';
        $app['mp.user.service.user.class'] = 'Mparaiso\User\Service\UserService';
        $app['mp.user.registration.type'] = 'Mparaiso\User\Form\RegistrationType';
        $app['mp.user.registration.model'] = function ($app) {
            return $app['mp.user.user.class'];
        };

        $app['mp.user.profile.type'] = 'Mparaiso\User\Form\ProfileType';
        $app['mp.user.profile.model'] = $app['mp.user.user.class'];

        $app['mp.user.login_template'] = "mp.user.login.html.twig";
        $app['mp.user.register_template'] = "mp.user.register.html.twig";

        $app['mp.user.routes.type'] = "yaml";
        $app['mp.user.routes.path'] = __DIR__ . "/../User/Resources/routing/mp.user.routing.yml";
        $app['mp.user.routes.prefix'] = "/";

        $app['mp.user.template.layout'] = "mp.user.layout.html.twig";
        $app['mp.user.template.profile'] = "mp.user.profile.html.twig";
        $app['mp.user.template.profile.update'] = "mp.user.profile_update.html.twig";
        $app['mp.user.template.profile.read'] = "mp.user.profile_read.html.twig";
        $app['mp.user.template.flash'] = "mp.user.flash.html.twig";
        $app['mp.user.template.status'] = "mp.user.status.html.twig";
        $app['mp.user.template_path'] = __DIR__ . "/../User/Resources/views";

        $app['mp.user.make_salt'] = $app->protect(function () {
            return uniqid();
        });


        $app['mp.user.resource.doctrine-orm.base'] = __DIR__ . "/../User/Resources/doctrine/";
        $app['mp.user.resource.doctrine-orm.concrete'] = __DIR__ . "/../User/Resources/doctrine-concrete";
        $app['mp.user.resource.mongodb-odm.base'] = __DIR__ . '/../User/Resources/mongodb-odm';
        $app['mp.user.resource.mongodb-odm.concrete'] = __DIR__ . '/../User/Resources/mongodb-odm-concrete';
    }

    function boot(Application $app)
    {
        /** twig * */
        $app['twig.loader.filesystem'] = $app->extend("twig.loader.filesystem", function ($loader, $app) {
                $loader->addPath($app['mp.user.template_path']); // FR: ajouter le répertoire des templates FOS à TWIG
                return $loader;
            }
        );
        /**
         * Choose what kind of manager to user , ORM ( doctrine-orm ) or ODM ( mongodb-odm )
         */
        if (isset($app['orm.em'])) {
            $app['orm.chain_driver'] = $app->share(
                $app->extend("orm.chain_driver", function (MappingDriverChain $chain, $app) {
                    $dir = $app['mp.user.resource.doctrine-orm.base'];
                    $chain->addDriver(new YamlDriver($dir), 'Mparaiso\User\Entity');
                    return $chain;
                }));
        }
        /** routes extension  */
        if (isset($app['mp.route_loader'])) {
            $app['mp.route_loader']->add($app['mp.user.routes.type'],
                $app['mp.user.routes.path'], $app['mp.user.routes.prefix']);
        }
    }


}

