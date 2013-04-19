<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 */
class User extends \Mparaiso\User\Entity\BaseUser
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $dinners;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $rsvps;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $roles;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dinners = new \Doctrine\Common\Collections\ArrayCollection();
        $this->rsvps = new \Doctrine\Common\Collections\ArrayCollection();
        $this->roles = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add dinners
     *
     * @param \Entity\Dinner $dinners
     * @return User
     */
    public function addDinner(\Entity\Dinner $dinners)
    {
        $this->dinners[] = $dinners;
    
        return $this;
    }

    /**
     * Remove dinners
     *
     * @param \Entity\Dinner $dinners
     */
    public function removeDinner(\Entity\Dinner $dinners)
    {
        $this->dinners->removeElement($dinners);
    }

    /**
     * Get dinners
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDinners()
    {
        return $this->dinners;
    }

    /**
     * Add rsvps
     *
     * @param \Entity\Rsvp $rsvps
     * @return User
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
     * Add roles
     *
     * @param \Mparaiso\User\Entity\Role $roles
     * @return User
     */
    public function addRole(\Mparaiso\User\Entity\Role $roles)
    {
        $this->roles[] = $roles;
    
        return $this;
    }

    /**
     * Remove roles
     *
     * @param \Mparaiso\User\Entity\Role $roles
     */
    public function removeRole(\Mparaiso\User\Entity\Role $roles)
    {
        $this->roles->removeElement($roles);
    }

    /**
     * Get roles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRoles()
    {
        return $this->roles->toArray();
    }
}
