<?php
/**
 * Created by PhpStorm.
 * User: xfarret
 * Date: 27/05/14
 * Time: 09:48
 */

namespace Medicheck\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Recipient
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class Recipient extends BaseUser implements \Serializable {

    /**
     * @var string
     *
     * @ORM\Column(name="num_secu", type="string", length=15, unique=false, nullable=true)
     */
    private $numSecu;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_child", type="boolean")
     */
    private $isChild;

    /**
     * @ORM\ManyToOne(targetEntity="Medicheck\UserBundle\Entity\User", inversedBy="recipients")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $relatedTo;

    /**
     * @param boolean $isChild
     */
    public function setIsChild($isChild)
    {
        $this->isChild = $isChild;
    }

    /**
     * @return boolean
     */
    public function getIsChild()
    {
        return $this->isChild;
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
     * @param mixed $relatedTo
     */
    public function setRelatedTo($relatedTo)
    {
        $this->relatedTo = $relatedTo;
    }

    /**
     * @return mixed
     */
    public function getRelatedTo()
    {
        return $this->relatedTo;
    }

    /**
     * Serializes the content of the current User object
     * @return string
     */
    public function serialize()
    {
        return \json_encode(
            array(
                $this->getFirstname(),
                $this->getLastname(),
                $this->getId()
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
            $this->firstname,
            $this->lastname,
            $this->id
            ) = \json_decode($serialized);
    }
}