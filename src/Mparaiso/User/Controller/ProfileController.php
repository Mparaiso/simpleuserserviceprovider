<?php

namespace Mparaiso\User\Controller;

use Silex\Application;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\Request;
use Mparaiso\User\Event\ProfileEvents;

/**
 * Description of ProfileController
 *
 * @author Mparaiso <mparaiso@online.fr>
 */
class ProfileController
{
    protected $userService;

    function __construct($userService)
    {
        $this->userService = $userService;
    }


    function index(Application $app, Request $req)
    {
        return $app['twig']->render($app['mp.user.template.profile']);
    }


    function read(Application $app, $username)
    {
        $user = $this->userService->findOneBy(array('username' => $username));
        if (NULL === $user) { #user not found
            $app->abort(500, "no user $username found");
        }
        return $app['twig']->render($app['mp.user.template.profile.read'], array(
            "user" => $user,
        ));
    }

    function update(Application $app, Request $req)
    {
        $model = $app['security']->getToken()->getUser();
        $type = new $app['mp.user.profile.type']();
        $form = $app['form.factory']->create($type, $model);
        if ("POST" === $req->getMethod()) {
            $form->bind($req);
            if ($form->isValid()) {
                //update the user and redirect
                $app['dispatcher']->dispatch(ProfileEvents::BEFORE_UPDATE, new GenericEvent($model));
                $this->userService->update($model);
                $app['dispatcher']->dispatch(ProfileEvents::AFTER_UPDATE, new GenericEvent($model));
                $app['session']->getFlashBag()->set("success", "Profile has been updated!");
                return $app->redirect($app['url_generator']->generate("mp.user.route.profile.index"));
            }
        }

        return $app['twig']->render($app['mp.user.template.profile.update'], array(
            "form" => $form->createView(),
        ));
    }

}

?>
