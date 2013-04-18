<?php

namespace Mparaiso\User\Controller;

use Silex\Application;
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
class RegistrationController {

    function register(Application $app, Request $req) {
        $class = new $app['mp.user.registration.type']();
        $model = new $app['mp.user.user.class'] ();
        $form = $app['form.factory']->create($class, $model);
        if ("POST" === $req->getMethod()) {
            $form->bind($req);
            if ($form->isValid()) {
                $encoder = $app["security.encoder_factory"];
                $model->setSalt($app['mp.user.make_salt']());
                $model->setPassword($encoder->getEncoder($model)->encodePassword($model->getPassword(), $model->getSalt()));
                $app['mp.user.user_service']->register($model);
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
