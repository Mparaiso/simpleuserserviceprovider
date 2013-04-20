<?php

namespace Mparaiso\Rdv\Service;

use Doctrine\ORM\EntityManager;
use Mparaiso\Rdv\Entity\BaseRsvp;

class RsvpService {

    private $em;
    private $rsvpClass;

    function __construct(EntityManager $em, $rsvpClass) {
        $this->em = $em;
        $this->rsvpClass = $rsvpClass;
    }

    function findOneBy(array $criteria = array(), $orderBy = null) {
        return $this->em->getRepository($this->rsvpClass)->findOneBy($criteria, $orderBy);
    }

    function find($id) {
        return $this->em->getRepository($this->rsvpClass)->find($id);
    }

    function save(BaseRsvp $rsvp, $flush = true) {
        $this->em->persist($rsvp);
        if ($flush) {
            $this->em->flush();
        }
        return $rsvp;
    }

    function delete(BaseRsvp $rsvp, $flush = true) {
        $this->em->remove($rsvp);
        if ($flush) {
            $this->em->flush();
        }
    }

}