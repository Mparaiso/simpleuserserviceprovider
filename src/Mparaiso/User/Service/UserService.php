<?php
namespace Mparaiso\User\Service;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Mparaiso\User\Entity\Base\User;

class UserService implements IUserService
{

    protected $roleClass;
    protected $userClass;
    protected $em;

    function __construct(ObjectManager $em, $userClass, $roleClass)
    {
        $this->em = $em;
        $this->userClass = $userClass;
        $this->roleClass = $roleClass;
    }

    function register(User $user)
    {
        if (count($user->getRoles()) <= 0) {
            $role_user = $this->em->getRepository("$this->roleClass")->findOneBy(array('role' => 'ROLE_USER'));
            $user->addRole($role_user);
        }
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

    function update(User $user, $flush = TRUE)
    {
        $this->em->persist($user);
        if ($flush) {
            $this->em->flush();
        }
        return TRUE;
    }


}