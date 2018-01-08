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
use Medicheck\UserBundle\Exception\RoleNotFoundException;

class RoleRepository extends EntityRepository {

    public function __construct(EntityManager $entityManager, $roleClass = 'Medicheck\UserBundle\Entity\UserRole') {
        parent::__construct($entityManager, $entityManager->getClassMetadata($roleClass));
    }

    /**
     * @param UserRole $role
     */
    public function saveOrUpdate(UserRole $role) {
        $this->getEntityManager()->persist($role);
        $this->getEntityManager()->flush();
    }

    /**
     * @return array
     */
    public function getAllRoles() {
        $q = $this
            ->createQueryBuilder('r')
            ->select('r')
            ->getQuery();

        return $q->getResult();
    }

    /**
     * @param $value
     * @return UserRole
     * @throws \Medicheck\UserBundle\Exception\RoleNotFoundException
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
            throw new RoleNotFoundException(
                sprintf('Unable to find MedicheckUserBundle:UserRole object identified by "%s".', $value),
                0, $e
            );
        }

        return $role;
    }

    /**
     * @return UserRole
     */
    public function getDefaultRoleUser() {
        try {
            return $this->getRoleByName("USER");
        } catch( \Exception $e) {
            $role = new UserRole("ROLE_USER");
            $role->setName("USER");

            $this->saveOrUpdate($role);

            return $role;
        }
    }
} 