<?php

namespace Mparaiso\User\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Form\FormBuilderInterface;

class ProfileType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->add("username")
            ->add("email", "email")
            ->add("password_verify", "password", array(
            "mapped"      => FALSE,
            "label"       => "enter your password to confirm changes",
            "constraints" => array(new UserPassword())
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return "profile";
    }
}