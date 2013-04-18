<?php

namespace Mparaiso\User\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of ProfileController
 *
 * @author Mparaiso <mparaiso@online.fr>
 */
class ProfileController {

    function index(Application $app, Request $req) {
        return $app['twig']->render($app['mp.user.template.profile']);
    }

    function update(Application $app, Request $req) {
        $model = new $app['mp.user.form.profile.model']();
        $form = new $app['mp.user.form.profile.type']();

        return $app['twig']->render("", array(
                    "form" => $form->createView(),
        ));
    }

}

?>
