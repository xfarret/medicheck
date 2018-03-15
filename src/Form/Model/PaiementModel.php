<?php

namespace App\Form\Model;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class PaiementModel
{
    /**
     * @var string
     */
    private $createAt;

    /**
     * @var string
     */
    private $act;

    /**
     * @var string
     */
    private $practitioner;

    /**
     * @var decimal
     */
    private $cost;

    /**
     * @var decimal
     */
    private $deductible;

    /**
     * @param mixed $act
     */
    public function setAct($act)
    {
        $this->act = $act;
    }

    /**
     * @return mixed
     */
    public function getAct()
    {
        return $this->act;
    }

    /**
     * @param mixed $cost
     */
    public function setCost($cost)
    {
        $this->cost = $cost;
    }

    /**
     * @return mixed
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @param mixed $createAt
     */
    public function setCreateAt($createAt)
    {
        $this->createAt = $createAt;
    }

    /**
     * @return mixed
     */
    public function getCreateAt()
    {
        return $this->createAt;
    }

    /**
     * @param mixed $deductible
     */
    public function setDeductible($deductible)
    {
        $this->deductible = $deductible;
    }

    /**
     * @return mixed
     */
    public function getDeductible()
    {
        return $this->deductible;
    }

    /**
     * @param mixed $practitioner
     */
    public function setPractitioner($practitioner)
    {
        $this->practitioner = $practitioner;
    }

    /**
     * @return mixed
     */
    public function getPractitioner()
    {
        return $this->practitioner;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('createAt', new Assert\Regex(array(
            'pattern' => '/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/',
        )));
    }
}