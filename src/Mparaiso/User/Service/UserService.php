<?php
namespace Mparaiso\User\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Mparaiso\User\Entity\BaseUser;

class UserService
{

    protected $roleClass;
    protected $userClass;
    protected $em;

    function __construct(EntityManager $em, $userClass, $roleClass)
    {
        $this->em = $em;
        $this->userClass = $userClass;
        $this->roleClass = $roleClass;
    }

    function register(BaseUser $user)
    {
        $role_user = $this->em->getRepository("$this->roleClass")->findOneBy(array('role' => 'ROLE_USER'));
        $user->addRole($role_user);
        $user->setAccountNonExpired(TRUE);
        $user->setAccountNonLocked(TRUE);
        $user->setCredentialsNonExpired(TRUE);
        $user->setEnabled(TRUE);
        $this->em->persist($user);
        $this->em->flush();
        return $user;
    }

    function find($id)
    {
        return $this->em->getRepository($this->userClass)->find($id);
    }

    function findOneBy(array $criteria)
    {
        return $this->em->getRepository($this->userClass)->findOneBy($criteria);
    }

    function update(BaseUser $user, $flush = TRUE)
    {
        $this->em->persist($user);
        if ($flush) {
            $this->em->flush();
        }
        return TRUE;
    }


}