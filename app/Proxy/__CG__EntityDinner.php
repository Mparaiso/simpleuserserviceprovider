<?php

namespace DoctrineProxies\__CG__\Entity;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ORM. DO NOT EDIT THIS FILE.
 */
class Dinner extends \Entity\Dinner implements \Doctrine\ORM\Proxy\Proxy
{
    private $_entityPersister;
    private $_identifier;
    public $__isInitialized__ = false;
    public function __construct($entityPersister, $identifier)
    {
        $this->_entityPersister = $entityPersister;
        $this->_identifier = $identifier;
    }
    /** @private */
    public function __load()
    {
        if (!$this->__isInitialized__ && $this->_entityPersister) {
            $this->__isInitialized__ = true;

            if (method_exists($this, "__wakeup")) {
                // call this after __isInitialized__to avoid infinite recursion
                // but before loading to emulate what ClassMetadata::newInstance()
                // provides.
                $this->__wakeup();
            }

            if ($this->_entityPersister->load($this->_identifier, $this) === null) {
                throw new \Doctrine\ORM\EntityNotFoundException();
            }
            unset($this->_entityPersister, $this->_identifier);
        }
    }

    /** @private */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    
    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return (int) $this->_identifier["id"];
        }
        $this->__load();
        return parent::getId();
    }

    public function setUser(\Entity\User $user = NULL)
    {
        $this->__load();
        return parent::setUser($user);
    }

    public function getUser()
    {
        $this->__load();
        return parent::getUser();
    }

    public function addRsvp(\Mparaiso\Rdv\Entity\Rsvp $rsvps)
    {
        $this->__load();
        return parent::addRsvp($rsvps);
    }

    public function removeRsvp(\Mparaiso\Rdv\Entity\Rsvp $rsvps)
    {
        $this->__load();
        return parent::removeRsvp($rsvps);
    }

    public function getRsvps()
    {
        $this->__load();
        return parent::getRsvps();
    }

    public function setTitle($title)
    {
        $this->__load();
        return parent::setTitle($title);
    }

    public function getTitle()
    {
        $this->__load();
        return parent::getTitle();
    }

    public function setEventDate($eventDate)
    {
        $this->__load();
        return parent::setEventDate($eventDate);
    }

    public function getEventDate()
    {
        $this->__load();
        return parent::getEventDate();
    }

    public function setDescription($description)
    {
        $this->__load();
        return parent::setDescription($description);
    }

    public function getDescription()
    {
        $this->__load();
        return parent::getDescription();
    }

    public function setHostedBy($hostedBy)
    {
        $this->__load();
        return parent::setHostedBy($hostedBy);
    }

    public function getHostedBy()
    {
        $this->__load();
        return parent::getHostedBy();
    }

    public function setContactPhone($contactPhone)
    {
        $this->__load();
        return parent::setContactPhone($contactPhone);
    }

    public function getContactPhone()
    {
        $this->__load();
        return parent::getContactPhone();
    }

    public function setAddress($address)
    {
        $this->__load();
        return parent::setAddress($address);
    }

    public function getAddress()
    {
        $this->__load();
        return parent::getAddress();
    }

    public function setCountry($country)
    {
        $this->__load();
        return parent::setCountry($country);
    }

    public function getCountry()
    {
        $this->__load();
        return parent::getCountry();
    }

    public function setLatitude($latitude)
    {
        $this->__load();
        return parent::setLatitude($latitude);
    }

    public function getLatitude()
    {
        $this->__load();
        return parent::getLatitude();
    }

    public function setLongitude($longitude)
    {
        $this->__load();
        return parent::setLongitude($longitude);
    }

    public function getLongitude()
    {
        $this->__load();
        return parent::getLongitude();
    }


    public function __sleep()
    {
        return array('__isInitialized__', 'title', 'eventDate', 'description', 'hostedBy', 'contactPhone', 'address', 'country', 'latitude', 'longitude', 'id', 'user');
    }

    public function __clone()
    {
        if (!$this->__isInitialized__ && $this->_entityPersister) {
            $this->__isInitialized__ = true;
            $class = $this->_entityPersister->getClassMetadata();
            $original = $this->_entityPersister->load($this->_identifier);
            if ($original === null) {
                throw new \Doctrine\ORM\EntityNotFoundException();
            }
            foreach ($class->reflFields as $field => $reflProperty) {
                $reflProperty->setValue($this, $reflProperty->getValue($original));
            }
            unset($this->_entityPersister, $this->_identifier);
        }
        
    }
}