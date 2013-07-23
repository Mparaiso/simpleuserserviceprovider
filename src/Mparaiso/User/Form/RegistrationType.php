<?php

namespace Mparaiso\User\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationType extends AbstractType {

    function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('username')
                ->add('email', 'email')
                ->add('password', 'repeated', array(
                    "type" => "password",
                    "first_options" => array(
                        "label" => "password"
                    ),
                    "second_options" => array(
                        "label" => "confirm password"
                    ), "property_path" => "password"
        ));
    }

    public function getName() {
        return "registration";
    }

}