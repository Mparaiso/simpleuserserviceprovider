<?php

namespace Mparaiso\User\Service;

use Doctrine\Common\Persistence\ObjectManager;
use Mparaiso\User\Entity\Base\User;

class ProfileService
{
    function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }

    function udpate(User $user)
    {

    }


}