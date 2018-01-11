<?php
/**
 * Copyright @Kolor
 * User: xfarret
 * Date: 26/10/2017
 * Time: 13:24
 */

namespace Medicheck\UserBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class RegisterUserModel
{
    private $firstname;
    private $lastname;
    private $numsecu;
    private $passwordUnencoded;
    private $email;

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @return mixed
     */
    public function getNumsecu()
    {
        return $this->numsecu;
    }

    /**
     * @param mixed $numsecu
     */
    public function setNumsecu($numsecu)
    {
        $this->numsecu = $numsecu;
    }

    /**
     * @return mixed
     */
    public function getPasswordUnencoded()
    {
        return $this->passwordUnencoded;
    }

    /**
     * @param mixed $passwordUnencoded
     */
    public function setPasswordUnencoded($passwordUnencoded)
    {
        $this->passwordUnencoded = $passwordUnencoded;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint(
            'numsecu',
            new Assert\Regex(
                array(
                    'pattern' =>
                        '/^[12][0-9]{2}(0[1-9]|1[0-2])(2[AB]|[0-9]{2})[0-9]{3}[0-9]{3}([0-9]{2})?$/x',
                )
            )
        );
    }

}