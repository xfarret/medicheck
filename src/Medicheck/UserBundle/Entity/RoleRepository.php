<?php
/**
 * Created by PhpStorm.
 * User: xavier
 * Date: 04/05/14
 * Time: 19:16
 */

namespace Medicheck\UserBundle\Entity;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class RoleRepository extends EntityRepository {

    public function __construct(EntityManager $entityManager, $roleClass = 'Medicheck\UserBundle\Entity\Role') {
        parent::__construct($entityManager, $entityManager->getClassMetadata($roleClass));
    }

    /**
     *
     */
    public function getAllRoles() {
        $q = $this
            ->createQueryBuilder('r')
            ->select('r')
            ->getQuery();

        return $q->getResult();
    }

    /**
     *
     */
    public function getRoleByName($value) {
        $q = $this
            ->createQueryBuilder('r')
            ->select('r')
            ->where('r.name = :value')
            ->setParameter('value', $value)
            ->getQuery();

        try {
            // La méthode Query::getSingleResult() lance une exception
            // s'il n'y a pas d'entrée correspondante aux critères
            $role = $q->getSingleResult();
        } catch (NoResultException $e) {
            throw new \Exception(
                sprintf('Unable to find MedicheckUserBundle:Role object identified by "%s".', $value),
                0, $e
            );
        }

        return $role;
    }
} 