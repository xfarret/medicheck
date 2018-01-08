<?php

namespace Medicheck\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Serializable;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class User extends BaseUser implements AdvancedUserInterface, Serializable, EquatableInterface
{
    /**
     * @var string
     *
     * @ORM\Column(name="num_secu", type="string", length=15, unique=true)
     */
    private $numSecu;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=32)
     */
    private $salt;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=40)
     */
    private $password;

    /**
     * @var string
     */
    private $passwordUnencoded;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=60, unique=true)
     */
    private $email;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @var boolean
     *
     * @ORM\Column(name="locked", type="boolean")
     */
    private $locked;

    /**
     * @var string
     */
    private $resettingPasswordToken;

    /**
     * @ORM\OneToMany(targetEntity="Medicheck\UserBundle\Entity\Recipient", mappedBy="relatedTo", cascade="all", orphanRemoval=true)
     */
    private $recipients;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Medicheck\UserBundle\Entity\UserRole")
     */
    private $roles;



    public function __construct() {
        $this->recipients = new ArrayCollection();
        $this->passwordUnencoded = null;
        $this->locked = false;
        $this->roles = new ArrayCollection();
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param boolean $isActive
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }

    /**
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * @param boolean $locked
     */
    public function setLocked($locked)
    {
        $this->locked = $locked;
    }

    /**
     * @return boolean
     */
    public function getLocked()
    {
        return $this->locked;
    }

    /**
     * @param string $numSecu
     */
    public function setNumSecu($numSecu)
    {
        $this->numSecu = $numSecu;
    }

    /**
     * @return string
     */
    public function getNumSecu()
    {
        return $this->numSecu;
    }

    /**
     * Set password
     *
     * @param  string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasPasswordUnencoded()
    {
        // toutes valeurs vides, false ou null sont considérées comme null
        return ($this->passwordUnencoded != null);
    }

    /**
     * @param string $passwordUnencoded
     */
    public function setPasswordUnencoded($passwordUnencoded)
    {
        $this->passwordUnencoded = $passwordUnencoded;
    }

    /**
     * @return string
     */
    public function getPasswordUnencoded()
    {
        return $this->passwordUnencoded;
    }

    /**
     * @param mixed $recipients
     */
    public function setRecipients($recipients)
    {
        foreach ($recipients as $recipient) {
            $recipient->setRelatedTo($this);
        }

        $this->recipients = $recipients;
    }

    /**
     * @return ArrayCollection
     */
    public function getRecipients()
    {
        return $this->recipients;
    }

    /**
     * @param string $resettingPasswordToken
     */
    public function setResettingPasswordToken($resettingPasswordToken)
    {
        $this->resettingPasswordToken = $resettingPasswordToken;
    }

    /**
     * @return string
     */
    public function getResettingPasswordToken()
    {
        return $this->resettingPasswordToken;
    }


    /**
     * Checks whether the user's account has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw an AccountExpiredException and prevent login.
     *
     * @return bool    true if the user's account is non expired, false otherwise
     *
     * @see AccountExpiredException
     */
    public function isAccountNonExpired()
    {
        return true;
    }

    /**
     * Checks whether the user is locked.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a LockedException and prevent login.
     *
     * @return bool    true if the user is not locked, false otherwise
     *
     * @see LockedException
     */
    public function isAccountNonLocked()
    {
        return !($this->locked == true);
    }

    /**
     * Checks whether the user's credentials (password) has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a CredentialsExpiredException and prevent login.
     *
     * @return bool    true if the user's credentials are non expired, false otherwise
     *
     * @see CredentialsExpiredException
     */
    public function isCredentialsNonExpired()
    {
        return true;
    }

    /**
     * Checks whether the user is enabled.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a DisabledException and prevent login.
     *
     * @return bool    true if the user is enabled, false otherwise
     *
     * @see DisabledException
     */
    public function isEnabled()
    {
        return $this->isActive;
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return UserRole[] The user roles
     */
    public function getRoles()
    {
        return $this->roles->toArray();
    }

    /**
     * Add role
     *
     * @param  UserRole $role
     * @return User
     */
    public function addRole(UserRole $role)
    {
        $this->roles->add($role);

        return $this;
    }

    /**
     * Remove role
     *
     * @param UserRole $role
     */
    public function removeRole(UserRole $role)
    {
        $this->roles->removeElement($role);
    }

    public function hasRole($roleName) {
        $result = false;

        foreach ( $this->roles->toArray() as $role) {
            if ( $role->getName() == $roleName ) {
                $result = true;
                break;
            }
        }

        return $result;
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set salt
     *
     * @param  string $salt
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->numSecu;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
    }

    /**
     * Serializes the content of the current User object
     * @return string
     */
    public function serialize()
    {
        return \json_encode(
            array(
                $this->numSecu,
                $this->roles,
                $this->id
            )
        );
    }

    /**
     * Unserializes the given string in the current User object
     * @param string
     */
    public function unserialize($serialized)
    {
        list(
            $this->numSecu,
            $this->roles,
            $this->id
            ) = \json_decode($serialized);
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint(
            'numSecu',
            new Assert\Regex(
                array(
                    'pattern' =>
                        '/^[12][0-9]{2}(0[1-9]|1[0-2])(2[AB]|[0-9]{2})[0-9]{3}[0-9]{3}([0-9]{2})?$/x',
                )
            )
        );
    }

    public function isEqualTo(UserInterface $user)
    {
//        if ($this->password !== $user->getPassword()) {
//            return false;
//        }
//
//        if ($this->salt !== $user->getSalt()) {
//            return false;
//        }

        if ($this->numSecu !== $user->getUsername()) {
            return false;
        }

        return true;
    }
}
