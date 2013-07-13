<?php

namespace Mparaiso\Rdv\Service;

use Doctrine\ORM\EntityManager;
use Mparaiso\Rdv\Entity\BaseRsvp;

class RsvpService
{

    private $em;
    private $rsvpClass;

    function __construct(EntityManager $em, $rsvpClass)
    {
        $this->em        = $em;
        $this->rsvpClass = $rsvpClass;
    }

    function findOneBy(array $criteria = array(), $orderBy = NULL)
    {
        return $this->em->getRepository($this->rsvpClass)->findOneBy($criteria, $orderBy);
    }

    function find($id)
    {
        return $this->em->getRepository($this->rsvpClass)->find($id);
    }

    function count(array $criteria = array())
    {
        $builder = $this->em->createQueryBuilder();
        $builder->select(" COUNT(r)")->from($this->rsvpClass, "r");
        if ( count($criteria) > 0) {
            foreach ($criteria as $key => $value) {
            $builder->where(" r.$key = :$key ");
            }
        }
        return $builder->setParameters($criteria)->getQuery()->getSingleScalarResult();
    }

    function save(BaseRsvp $rsvp, $flush = TRUE)
    {
        $this->em->persist($rsvp);
        if ($flush) {
            $this->em->flush();
        }
        return $rsvp;
    }

    function delete(BaseRsvp $rsvp, $flush = TRUE)
    {
        $this->em->remove($rsvp);
        if ($flush) {
            $this->em->flush();
        }
    }

}