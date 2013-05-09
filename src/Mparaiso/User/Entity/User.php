<?php

namespace Mparaiso\User\Entity;
use Mparaiso\User\Entity\Base\User as BaseUser;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * User
 */
class User extends BaseUser
{

    /**
     * @var integer
     */
    protected $id;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }


}