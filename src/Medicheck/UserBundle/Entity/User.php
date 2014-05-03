<?php

namespace Medicheck\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Medicheck\UserBundle\Entity\UserRepository")
 */
class User
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
     * @var string
     *
     * @ORM\Column(name="numSecu", type="string", length=255)
     */
    private $numSecu;

    /**
     * @var array
     *
     * @ORM\Column(name="beneficiaires", type="array")
     */
    private $beneficiaires;


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
     * Set numSecu
     *
     * @param string $numSecu
     * @return User
     */
    public function setNumSecu($numSecu)
    {
        $this->numSecu = $numSecu;

        return $this;
    }

    /**
     * Get numSecu
     *
     * @return string 
     */
    public function getNumSecu()
    {
        return $this->numSecu;
    }

    /**
     * Set beneficiaires
     *
     * @param array $beneficiaires
     * @return User
     */
    public function setBeneficiaires($beneficiaires)
    {
        $this->beneficiaires = $beneficiaires;

        return $this;
    }

    /**
     * Get beneficiaires
     *
     * @return array 
     */
    public function getBeneficiaires()
    {
        return $this->beneficiaires;
    }
}
