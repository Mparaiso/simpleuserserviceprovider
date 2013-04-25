<?php

namespace Mparaiso\User\Service;

use Doctrine\ORM\EntityManager;
use Mparaiso\User\Entity\BaseUser;

class ProfileService
{
    function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    function udpate(BaseUser $user)
    {

    }


}