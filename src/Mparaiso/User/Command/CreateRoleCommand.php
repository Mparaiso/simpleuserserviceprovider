<?php

namespace Mparaiso\User\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateRoleCommand extends Command {

    function configure() {
        parent::configure();
        $this->addArgument('name', InputArgument::REQUIRED, "The nicename of the role.")
                ->addArgument('role', InputArgument::REQUIRED, 'The system name of the role, FULL CAP, beginning with ROLE_.')
                ->setName("mp:user:role:create")
                ->setDescription("Create new role, ex: mp:user:role:create user ROLE_USER.");
    }

    function execute(InputInterface $input, OutputInterface $output) {
        $app = $this->getHelper("app")->getApplication();
        $em = $app['mp.user.em'];
        $roleClass = $app['mp.user.role.class'];
        $role = new $roleClass();
        $role->setName($input->getArgument('name'));
        $role->setRole($input->getArgument("role"));
        $em->persist($role);
        $em->flush();
        $output->writeln("A new role {$role->getName()}, {$role->getRole()} has been created.");
    }

}