<?php

namespace Mparaiso\User\Entity\Base;

use Serializable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * BaseUser
 */
abstract class User implements AdvancedUserInterface, Serializable
{

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $salt;

    /**
     * @var boolean
     */
    protected $accountNonExpired;

    /**
     * @var boolean
     */
    protected $accountNonLocked;

    /**
     * @var boolean
     */
    protected $credentialsNonExpired;

    /**
     * @var boolean
     */
    protected $enabled;

    /**
     * Set username
     *
     * @param string $username
     * @return BaseUser
     */
    public function setUsername($username) {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return BaseUser
     */
    public function setPassword($password) {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return BaseUser
     */
    public function setEmail($email) {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return BaseUser
     */
    public function setSalt($salt) {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt() {
        return $this->salt;
    }

    /**
     * Set accountNonExpired
     *
     * @param boolean $accountNonExpired
     * @return BaseUser
     */
    public function setAccountNonExpired($accountNonExpired) {
        $this->accountNonExpired = $accountNonExpired;

        return $this;
    }

    /**
     * Get accountNonExpired
     *
     * @return boolean
     */
    public function getAccountNonExpired() {
        return $this->accountNonExpired;
    }

    /**
     * Set accountNonLocked
     *
     * @param boolean $accountNonLocked
     * @return BaseUser
     */
    public function setAccountNonLocked($accountNonLocked) {
        $this->accountNonLocked = $accountNonLocked;

        return $this;
    }

    /**
     * Get accountNonLocked
     *
     * @return boolean
     */
    public function getAccountNonLocked() {
        return $this->accountNonLocked;
    }

    /**
     * Set credentialsNonExpired
     *
     * @param boolean $credentialsNonExpired
     * @return BaseUser
     */
    public function setCredentialsNonExpired($credentialsNonExpired) {
        $this->credentialsNonExpired = $credentialsNonExpired;

        return $this;
    }

    /**
     * Get credentialsNonExpired
     *
     * @return boolean
     */
    public function getCredentialsNonExpired() {
        return $this->credentialsNonExpired;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return BaseUser
     */
    public function setEnabled($enabled) {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled() {
        return $this->enabled;
    }

    public function serialize() {
        return serialize(array(
            $this->id,
        ));
    }

    public function unserialize($serialized) {

        list($this->id, ) = unserialize($serialized);
    }

    public function eraseCredentials() {
        
    }

    public function isAccountNonExpired() {
        return $this->accountNonExpired;
    }

    public function isAccountNonLocked() {
        return $this->accountNonLocked;
    }

    public function isCredentialsNonExpired() {
        return $this->credentialsNonExpired;
    }

    public function isEnabled() {
        return $this->enabled;
    }

    function __toString() {
        return $this->username;
    }

    /** contraintes de validation * */
    public static function loadValidatorMetadata(ClassMetadata $metadata) {
        #@note valider une entity unqiue : username doit être unique //
        $metadata->addConstraint(new UniqueEntity(array(
            'fields' => array('username'),
        )));
        $metadata->addConstraint(new UniqueEntity(array(
            "fields" => array('email'),
        )));
        $metadata->addPropertyConstraint("username",
                new Length(array('min' => 4, 'max' => 50)));
        $metadata->addPropertyConstraint("email",
                new Length(array('min' => 4, 'max' => 100)));
        $metadata->addPropertyConstraint("email", new Email());
        $metadata->addPropertyConstraint("password",
                new Length(array('min' => 4, 'max' => 100)));
        $metadata->addPropertyConstraint("password",
                new Regex(
                array("pattern" => '#\d+#', "message" => "the value must have at least 1 number")));
    }

    public function __construct() {
        
    }

    abstract function addRole(Role $role);

    abstract function removeRole(Role $role);

    abstract function getRoles();

    abstract function setRoles($roles);
}
