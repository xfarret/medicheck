<?php
/**
 * Created by PhpStorm.
 * User: xavier
 * Date: 05/06/14
 * Time: 23:09
 */

namespace Medicheck\CmsBundle\Manager;


use Medicheck\CmsBundle\Entity\PaiementRepository;

class PaiementManager {

    private $paiementRepository;

    public function __construct(PaiementRepository $paiementRepository)
    {
        $this->paiementRepository = $paiementRepository;
    }


    /**
     * @return PaiementRepository
     */
    public function getRepository()
    {
        return $this->paiementRepository;
    }

} 