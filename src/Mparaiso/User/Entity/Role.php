<?php

namespace Mparaiso\User\Entity;

use Doctrine\ORM\Mapping as ORM;
use Serializable;
use Symfony\Component\Security\Core\Role\RoleInterface;

/**
 * Role
 *
 * @ORM\Table(name="mp_user_roles")
 * @ORM\Entity
 */
class Role implements RoleInterface, Serializable
    {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=50)
     */
    protected $role;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

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
        return $this->role;
    }

    }