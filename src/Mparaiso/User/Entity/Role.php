<?php

namespace Mparaiso\User\Entity;

use Mparaiso\User\Entity\Base\Role as BaseRole;

/**
 * Role
 *
 */
class Role extends BaseRole
{

    /**
     * @var integer
     *
     */
    protected $id;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

}