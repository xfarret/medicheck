<?php

namespace Medicheck\CmsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Medicheck\UserBundle\Entity\User;

/**
 * PaiementRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PaiementRepository extends EntityRepository
{

    /**
     * @param User $user
     * @return array
     */
    public function getPaiements(User $user)
    {
        $q = $this
            ->createQueryBuilder('p')
            ->select('p')
            ->where('p.user = :user')
            ->setParameter('user', $user)
            ->getQuery();

        return $q->getResult();
    }

}
