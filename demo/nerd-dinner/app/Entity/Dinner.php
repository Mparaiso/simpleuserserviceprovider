<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Mparaiso\User\Entity\BaseUser;
use Mparaiso\Rdv\Entity\BaseRsvp;

/**
 * Dinner
 */
class Dinner extends \Mparaiso\Rdv\Entity\BaseDinner implements  \JsonSerializable {

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
    public function __construct() {
        $this->rsvps = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Add rsvps
     *
     * @param \Entity\Rsvp $rsvps
     * @return Dinner
     */
    public function addRsvp(\Entity\Rsvp $rsvps) {
        $this->rsvps[] = $rsvps;

        return $this;
    }

    /**
     * Remove rsvps
     *
     * @param \Entity\Rsvp $rsvps
     */
    public function removeRsvp(\Entity\Rsvp $rsvps) {
        $this->rsvps->removeElement($rsvps);
    }

    /**
     * Get rsvps
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRsvps() {
        return $this->rsvps;
    }

    /**
     * Set host
     *
     * @param \Entity\User $host
     * @return Dinner
     */
    public function setHost(\Entity\User $host = null) {
        $this->host = $host;

        return $this;
    }

    /**
     * Get host
     *
     * @return \Entity\User 
     */
    public function getHost() {
        return $this->host;
    }

    /**
     * HELPER METHODS
     */
    function isUserRegistered(BaseUser $user) {
        return $this->rsvps->exists(function($key,Rsvp $rsvp)use($user) {
            return $rsvp->getUser() === $user;
        });
    }


    /**
     * @note @php json serializer une classe
     */
    function jsonSerialize(){
        return array(
            "id"=>$this->id,
            "latitude"=>$this->latitude,
            "longitude"=>$this->longitude,
            "city"=>$this->city,
            "country"=>$this->country,
            "address"=>$this->address,
            "eventDate"=>$this->eventDate,
            "title"=>$this->title,
            "description"=>$this->description,
            "host"=>array(
                "username"=>$this->host->getUsername(),
                "id"=>$this->host->getId()
                )
            );
    }

    
}
