<?php

namespace Mparaiso\Rdv\Controller;

use Exception;
use Mparaiso\Rdv\Entity\BaseRsvp;
use Mparaiso\Rdv\Event\RsvpEvents;
use Mparaiso\Rdv\Service\RsvpService;
use Silex\Application;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of newPHPClass1
 *
 * @author Mparaiso <mparaiso@online.fr>
 */
class RsvpController {

    private $rsvp_service;

    function __construct(RsvpService $rsvp_service) {
        $this->rsvp_service = $rsvp_service;
    }

    function unregister(Request $request, Application $app, $id, $attendeeName) {
        $dinner = $app['mp.rdv.service.dinner']->find($id);
        $rsvp = $app['mp.rdv.service.rsvp']->findOneBy(array("dinner" => $dinner, "attendeeName" => $attendeeName));
        if ($rsvp) {
            $app['dispatcher']->dispatch(RsvpEvents::BEFORE_DELETE, new GenericEvent($rsvp, array("dinner" => $dinner, "attendeeName" => $attendeeName)));
            $app['mp.rdv.service.rsvp']->delete($rsvp);
            $app['dispatcher']->dispatch(RsvpEvents::AFTER_DELETE, new GenericEvent($rsvp, array("dinner" => $dinner, "attendeeName" => $attendeeName)));
            return $app->json(array("message" => "You unregistered from the event."));
        } else {
            return $app->json(array("message" => "You are not registered to the event."));
        }
    }

    function register(Request $request, Application $app, $id, $attendeeName) {
        $dinner = $app['mp.rdv.service.dinner']->find($id);
        $dinner === null AND $app->abort(500, "Dinner not found !");
        $rsvp = new $app['mp.rdv.entity.rsvp'];
        /* @var $rsvp BaseRsvp */
        $rsvp->setAttendeeName($attendeeName);
        $rsvp->setDinner($dinner);
        try {
            $app['dispatcher']->dispatch(RsvpEvents::BEFORE_CREATE, new GenericEvent($rsvp, array("dinner" => $dinner)));
            $this->rsvp_service->save($rsvp);
            $app['dispatcher']->dispatch(RsvpEvents::AFTER_CREATE, new GenericEvent($rsvp, array("dinner" => $dinner)));
            return $app->json(array("message" => "Thanks - we'll see you there!"));
        } catch (Exception $exc) {
            if ($app["debug"]) {
                return $app->json(array("message" => $exc->getMessage()));
            } else {
                return $app->json(array("message" => "An error occured, registration failed."));
            }
        }
    }

}

