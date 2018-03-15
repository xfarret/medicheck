<?php
/**
 * Created by PhpStorm.
 * User: xfarret
 * Date: 27/05/14
 * Time: 09:48
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Recipient
 *
 * @ORM\Table()
 * @UniqueEntity(fields={"firstname", "lastname"})
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
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="recipients")
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

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata
            ->addPropertyConstraint(
                'numSecu',
                new Assert\Regex(
                    array(
                        'pattern' =>
                            '/^[12][0-9]{2}(0[1-9]|1[0-2])(2[AB]|[0-9]{2})[0-9]{3}[0-9]{3}([0-9]{2})?$/x',
                    )
                )
            )
            ->addConstraint(
                new UniqueEntity(array(
                    'fields'  => array('firstname', 'lastname'),
                    'message' => 'Recipient already exists.',
                    )
                )
            );
    }
}