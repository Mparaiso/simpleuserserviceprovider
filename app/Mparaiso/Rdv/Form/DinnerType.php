<?php

namespace Mparaiso\Rdv\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class DinnerType extends AbstractType
{
    function buildForm(FormBuilderInterface $builder,array $options){
        $builder->add('title')
            ->add('description',"textarea")
                #@note @symfony changer l'apparence d'un champ datetime
                #@see http://spraed.com/2011/11/symfony2-forms-and-datetime-fields/
            ->add('eventDate',null,array('date_widget'=>'single_text','time_widget'=>'single_text'))
            ->add('hostedBy')
            ->add('contactPhone')
            ->add('address')
            ->add('country','country')
            ->add('latitude')
            ->add('longitude');
    }
    function getName(){
        return 'dinner';
    }
}