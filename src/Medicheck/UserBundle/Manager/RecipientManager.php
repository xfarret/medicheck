<?php
/**
 * Created by PhpStorm.
 * User: xavier
 * Date: 04/06/14
 * Time: 02:30
 */

namespace Medicheck\UserBundle\Manager;


use Medicheck\UserBundle\Entity\RecipientRepository;
use Medicheck\UserBundle\Entity\User;

class RecipientManager {

    /**
     * @var \Medicheck\UserBundle\Entity\RecipientRepository
     */
    private $recipientRepository;

    public function __construct(RecipientRepository $recipientRepository)
    {
        $this->recipientRepository = $recipientRepository;
    }

    /**
     * @param User $user
     */
    public function removeRecipients(User $user) {
        $attached = $user->getRecipients();
        foreach ( $this->getRepository()->getAllRecipientsByUser($user) as $recipient ) {
            if ( !$attached->contains($recipient) ) {
                $this->getRepository()->remove($recipient);
            }
        }
    }

    /**
     * @return RecipientRepository
     */
    private function getRepository() {
        return $this->recipientRepository;
    }
} 