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

    public function __construct(EntityManager $entityManager, $roleClass = 'Medicheck\UserBundle\Entity\Role') {
        parent::__construct($entityManager, $entityManager->getClassMetadata($roleClass));
    }

    public function saveOrUpdate(Role $role) {
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
     * @return Role
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
                sprintf('Unable to find MedicheckUserBundle:Role object identified by "%s".', $value),
                0, $e
            );
        }

        return $role;
    }

    /**
     * @return Role
     */
    public function getDefaultRoleUser() {
        try {
            return $this->getRoleByName("USER");
        } catch( \Exception $e) {
            $role = new Role();
            $role->setName("USER");
            $role->setRole("ROLE_USER");

            $this->saveOrUpdate($role);

            return $role;
        }
    }
} 