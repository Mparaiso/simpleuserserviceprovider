<?php

namespace Mparaiso\Rdv\Form;

use Symfony\Component\Form\FormExtensionInterface;
# @note FR ajouter une extensions de formulaire 
class RdvExtensions implements FormExtensionInterface{

    function __construct(){
        $this->types = array(
            "address" => "\Mparaiso\Rdv\Form\AddressType",
        );
    }
    /**
     * Returns a type by name.
     *
     * @param string $name The name of the type
     *
     * @return FormTypeInterface The type
     *
     * @throws Exception\FormException if the given type is not supported by this extension
     */
    public function getType($name){
        if(isset($this->types[$name])){
            return new $this->types[$name];
        }else{
            throw new \Exception\FormException;
        }
    }

    /**
     * Returns whether the given type is supported.
     *
     * @param string $name The name of the type
     *
     * @return Boolean Whether the type is supported by this extension
     */
    public function hasType($name){
        return isset($this->types[$name]);
    }

    /**
     * Returns the extensions for the given type.
     *
     * @param string $name The name of the type
     *
     * @return array An array of extensions as FormTypeExtensionInterface instances
     */
    public function getTypeExtensions($name){
        return array();
    }

    /**
     * Returns whether this extension provides type extensions for the given type.
     *
     * @param string $name The name of the type
     *
     * @return Boolean Whether the given type has extensions
     */
    public function hasTypeExtensions($name){
        return false;
    }

    /**
     * Returns the type guesser provided by this extension.
     *
     * @return FormTypeGuesserInterface|null The type guesser
     */
    public function getTypeGuesser(){
        return null;
    }
}