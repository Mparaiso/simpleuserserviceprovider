<?php

namespace Mparaiso\Rdv\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BaseDinner
 */
class BaseDinner
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @var \DateTime
     */
    protected $eventDate;

    /**
     * @var string
     */
    protected $description;
    /**
     * @var string
     */
    protected $contactPhone;

    /**
     * @var string
     */
    protected $address;

    /**
     * @var string
     */
    protected $city;

    /**
     * @var string
     */
    protected $country;

    /**
     * @var float
     */
    protected $latitude;

    /**
     * @var float
     */
    protected $longitude;


    /**
     * Set title
     *
     * @param string $title
     * @return BaseDinner
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set eventDate
     *
     * @param \DateTime $eventDate
     * @return BaseDinner
     */
    public function setEventDate($eventDate)
    {
        $this->eventDate = $eventDate;
    
        return $this;
    }

    /**
     * Get eventDate
     *
     * @return \DateTime 
     */
    public function getEventDate()
    {
        return $this->eventDate;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return BaseDinner
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }


    /**
     * Set contactPhone
     *
     * @param string $contactPhone
     * @return BaseDinner
     */
    public function setContactPhone($contactPhone)
    {
        $this->contactPhone = $contactPhone;
    
        return $this;
    }

    /**
     * Get contactPhone
     *
     * @return string 
     */
    public function getContactPhone()
    {
        return $this->contactPhone;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return BaseDinner
     */
    public function setAddress($address)
    {
        $this->address = $address;
    
        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    public function getCity(){
        return $this->city;
    }

    public function setCity($city){
        $this->city = $city;
        return $this;
    }
    /**
     * Set country
     *
     * @param string $country
     * @return BaseDinner
     */
    public function setCountry($country)
    {
        $this->country = $country;
    
        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set latitude
     *
     * @param float $latitude
     * @return BaseDinner
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    
        return $this;
    }

    /**
     * Get latitude
     *
     * @return float 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     * @return BaseDinner
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    
        return $this;
    }

    /**
     * Get longitude
     *
     * @return float 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }
    /**
     * @var string
     */
    protected $hostedBy;


    /**
     * Set hostedBy
     *
     * @param string $hostedBy
     * @return BaseDinner
     */
    public function setHostedBy($hostedBy)
    {
        $this->hostedBy = $hostedBy;
    
        return $this;
    }

    /**
     * Get hostedBy
     *
     * @return string 
     */
    public function getHostedBy()
    {
        return $this->hostedBy;
    }
}