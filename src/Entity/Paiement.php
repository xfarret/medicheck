<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;

/**
 * Paiement
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class Paiement
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_at", type="datetime")
     */
    private $createAt;

    /**
     * @var string
     *
     * @ORM\Column(name="act", type="string", length=255)
     */
    private $act;

    /**
     * @var string
     *
     * @ORM\Column(name="practitioner", type="string", length=255)
     */
    private $practitioner;

    /**
     * @var decimal
     *
     * @ORM\Column(name="cost", type="decimal")
     */
    private $cost;

    /**
     * @var decimal
     *
     * @ORM\Column(name="deductible", type="decimal")
     */
    private $deductible;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $user;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set createAt
     *
     * @param \DateTime $createAt
     * @return Paiement
     */
    public function setCreateAt(\DateTime $createAt)
    {
        $this->createAt = $createAt;

        return $this;
    }

    /**
     * Get createAt
     *
     * @return \DateTime
     */
    public function getCreateAt()
    {
        return $this->createAt;
    }

    /**
     * Set act
     *
     * @param string $act
     * @return Paiement
     */
    public function setAct($act)
    {
        $this->act = $act;

        return $this;
    }

    /**
     * Get act
     *
     * @return string 
     */
    public function getAct()
    {
        return $this->act;
    }

    /**
     * Set practitioner
     *
     * @param string $practitioner
     * @return Paiement
     */
    public function setPractitioner($practitioner)
    {
        $this->practitioner = $practitioner;

        return $this;
    }

    /**
     * Get practitioner
     *
     * @return string 
     */
    public function getPractitioner()
    {
        return $this->practitioner;
    }

    /**
     * Set cost
     *
     * @param decimal $cost
     * @return Paiement
     */
    public function setCost($cost)
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * Get cost
     *
     * @return decimal
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Set deductible
     *
     * @param decimal $deductible
     * @return Paiement
     */
    public function setDeductible($deductible)
    {
        $this->deductible = $deductible;

        return $this;
    }

    /**
     * Get deductible
     *
     * @return decimal
     */
    public function getDeductible()
    {
        return $this->deductible;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}
