<?php

namespace Mparaiso\Rdv\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BaseRsvp
 */
class BaseRsvp
{
    /**
     * @var string
     */
    private $attendeeName;


    /**
     * Set attendeeName
     *
     * @param string $attendeeName
     * @return BaseRsvp
     */
    public function setAttendeeName($attendeeName)
    {
        $this->attendeeName = $attendeeName;
    
        return $this;
    }

    /**
     * Get attendeeName
     *
     * @return string 
     */
    public function getAttendeeName()
    {
        return $this->attendeeName;
    }
}