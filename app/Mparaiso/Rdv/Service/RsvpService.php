<?php

namespace Mparaiso\Rdv\Service;

use Doctrine\ORM\EntityManager;

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

}