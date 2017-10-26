<?php
/**
 * Copyright @Kolor
 * User: xfarret
 * Date: 26/10/2017
 * Time: 13:24
 */

namespace Medicheck\UserBundle\Form\Model;


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


}