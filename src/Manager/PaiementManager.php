<?php
/**
 * Created by PhpStorm.
 * User: xavier
 * Date: 05/06/14
 * Time: 23:09
 */

namespace App\Manager;



use App\Repository\PaiementRepository;

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