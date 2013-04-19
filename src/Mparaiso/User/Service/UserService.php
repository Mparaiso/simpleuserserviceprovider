<?php
namespace Mparaiso\User\Service;

use Doctrine\ORM\EntityManager;
use Mparaiso\User\Entity\BaseUser;

class UserService {

    protected $roleClass;
    protected $userClass;
    protected $em;

    function __construct(EntityManager $em, $userClass, $roleClass) {
        $this->em = $em;
        $this->userClass = $userClass;
        $this->roleClass = $roleClass;
    }

    function register(BaseUser $user) {
        $role_user = $this->em->getRepository("$this->roleClass")->findOneBy(array('role' => 'ROLE_USER'));
        $user->addRole($role_user);
        $user->setAccountNonExpired(true);
        $user->setAccountNonLocked(true);
        $user->setCredentialsNonExpired(true);
        $user->setEnabled(true);
        $this->em->persist($user);
        $this->em->flush();
        return $user;
    }

}