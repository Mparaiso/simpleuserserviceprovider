<?php

namespace Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Mparaiso\Rdv\Form\DinnerType as BaseDinnerType;

class DinnerType extends BaseDinnerType {

    function buildForm(FormBuilderInterface $builder, array $options) {
        parent::buildForm($builder, $options);
        $builder->remove("hostedBy");
    }

}