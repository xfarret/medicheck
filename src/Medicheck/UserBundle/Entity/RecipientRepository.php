<?php
/**
 * Created by PhpStorm.
 * User: xavier
 * Date: 04/06/14
 * Time: 02:37
 */

namespace Medicheck\UserBundle\Entity;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class RecipientRepository extends EntityRepository {

    public function __construct(EntityManager $entityManager, $recipientClass = '\Medicheck\UserBundle\Entity\Recipient')
    {
        parent::__construct($entityManager, $entityManager->getClassMetadata($recipientClass));
    }

    /**
     * {@inheritDoc}
     */
    public function add(Recipient $recipient)
    {
        $this->save($recipient);
    }

    /**
     * {@inheritDoc}
     */
    public function save(Recipient $recipient)
    {
        $this->_em->persist($recipient);
        $this->_em->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function remove(Recipient $recipient)
    {
        $this->_em->remove($recipient);
        $this->_em->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getAllRecipientsByUser(User $user)
    {
        $q = $this
            ->createQueryBuilder('r')
            ->select('r')
            ->where('r.relatedTo = :user')
            ->setParameter('user', $user)
            ->getQuery();

        return $q->getResult();
    }
} 