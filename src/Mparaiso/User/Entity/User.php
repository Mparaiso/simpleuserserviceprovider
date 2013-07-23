<?php

namespace Mparaiso\User\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Mparaiso\User\Entity\Base\User as BaseUser;
use Mparaiso\User\Entity\Base\Role;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * User
 */
class User extends BaseUser implements AdvancedUserInterface
{

    /**
     * @var integer
     */
    protected $id;

    /**
     *
     * @var ArrayCollection
     */
    protected $roles;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    function __construct()
    {
        parent::__construct();
        $this->roles = new ArrayCollection;
    }

    public function removeRole(Role $role)
    {
        $this->roles->removeElement($role);
    }

    public function addRole(Role $role)
    {
        $this->roles[] = $role;
        return $this;
    }

    public function getRoles()
    {
        return $this->roles->toArray();
    }

    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /** validate user entity */
    static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addConstraint(new UniqueEntity(array("username")));
        $metadata->addConstraint(new UniqueEntity(array("email")));
        $metadata->addPropertyConstraint("username", new NotNull());
        $metadata->addPropertyConstraint("username", new Length(array("min" => 5, "max"=>100)));
        $metadata->addPropertyConstraint("email", new NotNull());
        $metadata->addPropertyConstraint("email", new Length(array("min" => 5, "max"=>100)));
        $metadata->addPropertyConstraint("password", new NotNull());
        $metadata->addPropertyConstraint("password", new Length(array("min" => 5, "max"=>100)));
    }

}