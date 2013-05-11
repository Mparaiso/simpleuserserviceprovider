<?php

namespace Mparaiso\User\Controller;

use Silex\Application;
use Mparaiso\User\Service\IUserService;
use Mparaiso\User\Event\RegistrationEvents;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\Request;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RegisterController
 *
 * @author Mparaiso <mparaiso@online.fr>
 */
class RegistrationController
{
    protected $userService;

    function __construct(IUserService $userService)
    {
        $this->userService = $userService;
    }

    function register(Application $app, Request $req)
    {
        $class = new $app['mp.user.registration.type']();
        $model = new $app['mp.user.user.class'] ();
        $form  = $app['form.factory']->create($class, $model);
        if ("POST" === $req->getMethod()) {
            $form->bind($req);
            if ($form->isValid()) {
                $encoder = $app["security.encoder_factory"];
                $model->setSalt($app['mp.user.make_salt']());
                $model->setPassword($encoder->getEncoder($model)->encodePassword($model->getPassword(), $model->getSalt()));
                $app["dispatcher"]->dispatch(RegistrationEvents::BEFORE_REGISTER, new GenericEvent($model));
                $this->userService->register($model);
                $app["dispatcher"]->dispatch(RegistrationEvents::AFTER_REGISTER, new GenericEvent($model));
                $app['session']->getFlashBag()->set("success", "you registered successfully,please login");
                return $app->redirect($app['url_generator']->generate('mp.user.route.login'));
            }
        }
        return $app['twig']->render($app['mp.user.register_template'], array(
            "form" => $form->createView()
        ));
    }

}

?>
