<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Mparaiso\Rdv\Entity\BaseRsvp;

/**
 * Rsvp
 */
class Rsvp extends BaseRsvp {

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var \Entity\User
     */
    protected $user;
    
    protected $dinner;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }


    /**
     * Set user
     *
     * @param \Entity\User $user
     * @return Rsvp
     */
    public function setUser(\Entity\User $user = null) {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Entity\User 
     */
    public function getUser() {
        return $this->user;
    }

    public function setDinner(Dinner $dinner = null) {
        $this->dinner = $dinner;
    }

    public function getDinner() {
        return $this->dinner;
    }


    /**
     * Set id
     *
     * @param integer $id
     * @return Rsvp
     */
    public function setId($id)
    {
        $this->id = $id;
    
        return $this;
    }
}