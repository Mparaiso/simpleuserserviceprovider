<?php

namespace Mparaiso\User\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of SecurityController
 *
 * @author Mparaiso <mparaiso@online.fr>
 */
class SecurityController {

    function login(Application $app, Request $req) {
        return $app['twig']->render($app['mp.user.login_template'], array(
                    'error' => $app['security.last_error']($req),
                    'last_username' => $app['session']->get('_security.last_username'),
        ));
    }

    function logout() {
        
    }

    function loginCheck(Application $app, Request $req) {
        
    }

}

