<?php
namespace Mparaiso\User\Service;

use Mparaiso\User\Entity\Base\User;

interface IUserService
{


    function register(User $user);


    function find($id);


    function findOneBy(array $criteria);


    function update(User $user);
}