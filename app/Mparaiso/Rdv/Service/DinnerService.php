<?php

namespace Mparaiso\Rdv\Service;

use Doctrine\ORM\EntityManager;
use Mparaiso\Rdv\Entity\BaseDinner;
use Mparaiso\Rdv\Entity\Dinner;

/**
 * FR : gère les dinez
 */
class DinnerService {

    private $em;
    protected $cn;

    function __construct(EntityManager $em, $className) {
        $this->em = $em;
        $this->cn = $className;
    }

    /**
     * FR : trouver tout les diners
     * @return Dinner[]
     */
    function findAll() {
        return $this->em->getRepository($this->cn)->findAll();
    }

    function find($id) {
        return $this->em->find($this->cn, $id);
    }

    /**
     * FR : trouver les futurs diners
     * @return Dinner[]
     */
    public function delete(Dinner $dinner) {
        $this->em->remove($dinner);
        $this->em->flush();
        return $dinner;
    }

    public function count() {
        return $this->em
                        ->createQuery("select count(d) from $this->cn d where d.eventDate >= CURRENT_TIMESTAMP()")
                        ->getScalarResult();
    }

    /**
     * FR : trouver les futurs diners
     * @return Dinner[]
     */
    function findUpcomingDinners($offset = null, $limit = null) {
        $qb = $this->em->createQueryBuilder();
        $qb->select("d");
        $qb->from(" $this->cn ", "d");
        $qb->where(" d.eventDate > CURRENT_TIMESTAMP() ")->orderBy("d.eventDate", "DESC");
        $qb->setFirstResult($offset);
        $qb->setMaxResults($limit);
        return $qb->getQuery()->execute();
    }

    function save(BaseDinner $dinner) {
        $this->em->persist($dinner);
        $this->em->flush();
        return $dinner;
    }

}