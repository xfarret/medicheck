<?php

namespace Medicheck\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Paiement
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Medicheck\CmsBundle\Entity\PaiementRepository")
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
     * @var integer
     *
     * @ORM\Column(name="create_at", type="integer")
     */
    private $createAt;

    /**
     * @var string
     *
     * @ORM\Column(name="act", type="string", length=125)
     */
    private $act;

    /**
     * @var string
     *
     * @ORM\Column(name="practitioner", type="string", length=255)
     */
    private $practitioner;

    /**
     * @var integer
     *
     * @ORM\Column(name="cost", type="integer")
     */
    private $cost;

    /**
     * @var integer
     *
     * @ORM\Column(name="deductible", type="integer")
     */
    private $deductible;


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
     * @param integer $createAt
     * @return Paiement
     */
    public function setCreateAt($createAt)
    {
        $this->createAt = $createAt;

        return $this;
    }

    /**
     * Get createAt
     *
     * @return integer 
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
        $this->act = $actName;

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
     * @param integer $cost
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
     * @return integer 
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Set deductible
     *
     * @param integer $deductible
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
     * @return integer 
     */
    public function getDeductible()
    {
        return $this->deductible;
    }
}
