<?php

namespace Mparaiso\User\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateUserCommand extends Command
{

    function configure()
    {
        parent::configure();
        $this->addArgument('username', InputArgument::REQUIRED, "the username")
            ->addArgument('password', InputArgument::REQUIRED, 'the password ')
            ->addArgument('email', InputArgument::REQUIRED, 'the email ')
            ->addArgument('role', InputArgument::REQUIRED, 'The user role, FULL CAP, beginning with ROLE_.')
            ->setName("mp:user:create")
            ->setDescription("Create new user, ex: mp:user:create username password email ROLE_USER.");
    }

    function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getHelper("app")->getApplication();
        $role = $app['mp.user.role_service']->findOneBy(array("role" => $input->getArgument('role')));
        if ($role == null) {
            $output->writeln("role not " . $input->getArgument('role') . " found ! aborting.");
            return;
        }
        $user = new  $app['mp.user.user.class']();
        $user->setSalt($app['mp.user.make_salt']());
        $encoder = $app["security.encoder_factory"];
        $user->setUsername($input->getArgument('username'));
        $user->setEmail($input->getArgument("email"));
        $user->setPassword($encoder->getEncoder($user)->encodePassword($input->getArgument('password'), $user->getSalt()));
        $user->addRole($role);
        $error_list = $app["validator"]->validate($user);
        if (count($error_list) <= 0) {
            $app["mp.user.service.user"]->register($user);
            $output->writeln("A new user ".$user->getUsername()." has been created. ");
        } else {
            $output->writeln("Error creating user." . $error_list);
        }

    }

}