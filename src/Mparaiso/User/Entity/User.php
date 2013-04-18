<?php

namespace Mparaiso\User\Entity;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * User
 */
class User extends BaseUser {

    /**
     * @var integer
     */
    protected $id;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /** contraintes de validation * */
    public static function loadValidatorMetadata(ClassMetadata $metadata) {
        #@note valider une entity unqiue : username doit être unique //
        $metadata->addConstraint(new UniqueEntity(array(
            'fields' => array('username'),
            "service" => "validator.unique_entity",
        )));
        $metadata->addConstraint(new UniqueEntity(array(
            "fields" => array('email'),
            "service" => "validator.unique_entity",
        )));
        $metadata->addPropertyConstraint("username", new Length(array('min' => 4, 'max' => 50)));
        $metadata->addPropertyConstraint("email", new Length(array('min' => 4, 'max' => 100)));
        $metadata->addPropertyConstraint("email", new Email());
        $metadata->addPropertyConstraint("password", new Length(array('min' => 4, 'max' => 100)));
        $metadata->addPropertyConstraint("password", new Regex(
                array("pattern" => '#\d+#', "message" => "the value must have at least 1 number")));
    }
    
    function getRoles(){
        return parent::getRoles()->toArray();
    }

}