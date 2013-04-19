<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dinner
 */
class Dinner extends \Mparaiso\Rdv\Entity\BaseDinner
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $rsvps;

    /**
     * @var \Entity\User
     */
    protected $host;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->rsvps = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add rsvps
     *
     * @param \Entity\Rsvp $rsvps
     * @return Dinner
     */
    public function addRsvp(\Entity\Rsvp $rsvps)
    {
        $this->rsvps[] = $rsvps;
    
        return $this;
    }

    /**
     * Remove rsvps
     *
     * @param \Entity\Rsvp $rsvps
     */
    public function removeRsvp(\Entity\Rsvp $rsvps)
    {
        $this->rsvps->removeElement($rsvps);
    }

    /**
     * Get rsvps
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRsvps()
    {
        return $this->rsvps;
    }

    /**
     * Set host
     *
     * @param \Entity\User $host
     * @return Dinner
     */
    public function setHost(\Entity\User $host = null)
    {
        $this->host = $host;
    
        return $this;
    }

    /**
     * Get host
     *
     * @return \Entity\User 
     */
    public function getHost()
    {
        return $this->host;
    }
}
