<?php
/**
 * Created by PhpStorm.
 * User: xavier
 * Date: 04/06/14
 * Time: 02:30
 */

namespace App\Manager;


use App\Entity\User;
use App\Repository\RecipientRepository;

class RecipientManager {

    /**
     * @var RecipientRepository
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