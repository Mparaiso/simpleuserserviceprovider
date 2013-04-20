<?php

namespace Mparaiso\Rdv\Controller;

use Mparaiso\Rdv\Entity\Dinner;
use Mparaiso\Rdv\Event\DinnerBeforeCreateEvent;
use Mparaiso\Rdv\Event\DinnerEvents;
use Mparaiso\Rdv\Form\DinnerType;
use Mparaiso\Rdv\Service\DinnerService;
use Silex\Application;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\Request;

class DinnerController {

    /**
     * @var DinnerService 
     */
    private $ds;
    private $twig;

    function __construct(DinnerService $ds) {
        $this->ds = $ds;
    }

    function index(Request $req, Application $app) {
        $offset = (int) $req->query->get("offset", 0);
        $limit = (int) $req->query->get("limit", 10);
        $dinners = $this->ds->findUpcomingDinners($offset * $limit, $limit);
        $count = $this->ds->count();
        return $app['twig']->render("rdv_dinner_index.html.twig", array(
                    "dinners" => $dinners,
                    "offset" => $offset,
                    "limit" => $limit,
                    "count" => $count,
        ));
    }

    function read(Application $app, $id) {
        return $app['twig']->render($app['mp.rdv.templates.dinner.read'], array(
                    "dinner" => $this->ds->find($id),
        ));
    }

    function create(Request $r, Application $app) {
        $d = new $app['mp.rdv.entity.dinner'];
        $type = new $app['mp.rdv.form.dinner'];
        $form = $app['form.factory']->create($type, $d);
        if ("POST" === $r->getMethod()) {
            $form->bind($r);
            if ($form->isValid()) {
                $app['dispatcher']->dispatch(DinnerEvents::BEFORE_CREATE, new GenericEvent($d));
                $this->ds->save($d);
                $app["dispatcher"]->dispatch(DinnerEvents::AFTER_CREATE, new GenericEvent($d));
                $app['session']->getFlashBag()->set('success', "Dinnner \"{$d->getTitle()}\" saved!");
                return $app->redirect($app['url_generator']->generate('rdv_dinner_read', array(
                                    'id' => $d->getId()
                )));
            }
        }
        return $app['twig']->render($app['mp.rdv.templates.dinner.create'], array(
                    'form' => $form->createView()
        ));
    }

    function update(Request $r, Application $app, $id) {
        $dinner = $this->ds->find($id);
        $dinner === null AND $app->abort(500, 'dinner not found');
        $type = new $app['mp.rdv.form.dinner'];
        $form = $app['form.factory']->create($type, $dinner);
        if ("POST" === $r->getMethod()) {
            $form->bind($r);
            if ($form->isValid()) {
                $app['dispatcher']->dispatch(DinnerEvents::BEFORE_UPDATE, new GenericEvent($dinner));
                $this->ds->save($dinner);
                $app['dispatcher']->dispatch(DinnerEvents::AFTER_UPDATE, new GenericEvent(($dinner)));
                $app['session']->getFlashBag()->set('success', "Dinnner \"{$dinner->getTitle()}\" updated!");
                return $app->redirect($app['url_generator']->generate('rdv_dinner_read', array(
                                    'id' => $id,
                )));
            }
        }
        return $app['twig']->render($app['mp.rdv.templates.dinner.update'], array(
                    'form' => $form->createView()
                        )
        );
    }

    function delete(Request $r, Application $app, $id) {
        $dinner = $this->ds->find($id);
        $dinner === null AND $app->abort(500, "Resource not found");
        if ("POST" === $r->getMethod() && $r->get('delete-dinner') !== null) {
            $app['dispatcher']->dispatch(DinnnerEvents::BEFORE_DELETE,new GenericEvent($dinner));
            $this->ds->delete($dinner);
            $app['dispatcher']->dispatch(DinnnerEvents::AFTER_DELETE,new GenericEvent($dinner));
            $app["session"]->getFlashBag()->set("success", "Dinner {$dinner->getTitle()} deleted");
            return $app->redirect($app['url_generator']->generate("rdv_dinner_index"));
        }
        return $app['twig']->render($app['mp.rdv.templates.dinner.delete'], array(
                    "dinner" => $dinner,
        ));
    }

}

