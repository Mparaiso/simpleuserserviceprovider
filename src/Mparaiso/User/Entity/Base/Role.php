<?php

namespace Mparaiso\User\Entity\Base;

use Serializable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\Role\RoleInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * Role
 *
 */
abstract class Role implements RoleInterface, Serializable
{

    /**
     * @var string
     *
     */
    protected $name;

    /**
     * @var string
     *
     */
    protected $role;

    /**
     * Get id
     *
     * @return integer 
     */
    abstract function getId();

    /**
     * Set name
     *
     * @param string $name
     * @return Role
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set role
     *
     * @param string $role
     * @return Role
     */
    public function setRole($role) {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string 
     */
    public function getRole() {
        return $this->role;
    }

    public function serialize() {
        return serialize(array(
          $this->id, $this->name, $this->role
        ));
    }

    /**
     * @see Serializable::unserialize()
     */
    public function unserialize($serialized) {
        list (
            $this->id, $this->name, $this->role
            ) = unserialize($serialized);
    }

    function __toString() {
        return $this->name;
    }


}