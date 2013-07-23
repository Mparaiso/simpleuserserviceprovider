<?php

namespace Mparaiso\Rdv\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AddressType extends AbstractType
{
    function buildForm(FormBuilderInterface $builder,array $options){
        $builder->add('address')
            ->add('city');
                
    }
    function getName(){
        return 'address';
    }

    function getParent(){
        return "form";
    }
}