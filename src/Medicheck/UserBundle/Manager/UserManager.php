<?php

namespace Medicheck\UserBundle\Manager;

use Medicheck\UserBundle\Entity\User;
use Medicheck\UserBundle\Exception\UpdateException;
use Medicheck\UserBundle\Entity\UserRepository;
use Medicheck\UserBundle\Exception\ResettingPasswordExpiredException;
use Medicheck\UserBundle\Exception\ResettingPasswordInvalidSecretException;
use Medicheck\UserBundle\Exception\ResettingPasswordAlreadyDoneException;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class UserManager
{

    protected $encoderFactory;

    /**
     * @var integer
     */
    private $passwordResettingTtl;

    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(EncoderFactoryInterface $encoderFactory, UserRepository $userRepository, $passwordResettingTtl)
    {
        if (!is_numeric($passwordResettingTtl)) {
            throw new \InvalidArgumentException('password resetting ttl has to be a numeric');
        }

        $this->encoderFactory = $encoderFactory;
        $this->userRepository = $userRepository;
        $this->passwordResettingTtl = (int) $passwordResettingTtl;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getUserById($id)
    {
        return $this->getUserRepository()->findOneBy(array('id' => $id));
    }

    /**
     * @param $username
     * @return mixed
     */
    public function getUserByUsername($username)
    {
        return $this->getUserRepository()->loadUserByUsername($username);
    }

    /**
     * @param User $user
     * @return bool
     * @throws \Medicheck\UserBundle\Exception\UpdateException
     */
    public function updateUser(User $user)
    {
        if ($user->hasPasswordUnencoded()) {
            $salt = md5(time());

            $encoder = $this->encoderFactory->getEncoder($user);
            $password = $encoder->encodePassword(
                $user->getPasswordUnencoded(), $salt
            );

            $user->setSalt($salt);
            $user->setPassword($password);
        }

        try {
            $this->userRepository->save($user);
            return true;
        } catch (\Exception $e) {
            throw new UpdateException('error.persist.user', 201, $e);
        }
    }

    /**
     * @param User $user
     */
    public function removeUser(User $user)
    {
        $this->userRepository->remove($user);
    }

    /**
     * @param User $user
     * @return $this
     */
    public function toggle(User $user)
    {
        $user->setIsActive(!$user->getIsActive());

        $this->getUserRepository()->save($user);

        return $this;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function isActive(User $user)
    {
        return $user->getIsActive();
    }

    /**
     * @param User $user
     * @return int
     * @throws \Medicheck\UserBundle\Exception\ResettingPasswordAlreadyDoneException
     */
    public function demandResetPassword(User $user)
    {
        $definedSecret = $user->getResettingPasswordToken();

        if ($definedSecret && !$this->isPasswordResettingExpired($definedSecret)) {
            throw new ResettingPasswordAlreadyDoneException();
        }

        $secret = time();

        $user->setResettingPasswordToken($secret);

        $this->updateUser($user);

        return $secret;
    }

    /**
     * @param User $user
     * @param $secret
     * @param $plainPassword
     * @throws \Medicheck\UserBundle\Exception\ResettingPasswordInvalidSecretException
     * @throws \Medicheck\UserBundle\Exception\ResettingPasswordExpiredException
     */
    public function applyResetPassword(User $user, $secret, $plainPassword)
    {
        if ($secret !== $user->getResettingPasswordToken()) {
            throw new ResettingPasswordInvalidSecretException();
        }

        if ($this->isPasswordResettingExpired($secret)) {
            throw new ResettingPasswordExpiredException();
        }


        $user->setResettingPasswordToken(null);
        $user->setPasswordUnencoded($plainPassword);

        $this->updateUser($user);
    }

    /**
     * @param User $user
     * @param $passwordToValid
     * @return bool
     */
    public function checkPasswordValidity(User $user, $passwordToValid) {

        $salt = $user->getSalt();
        $encoder = $this->encoderFactory->getEncoder($user);
        $passwordToValidEncoded = $encoder->encodePassword(
            $passwordToValid, $salt
        );

        if ( $user->getPassword() == $passwordToValidEncoded ) {
            return true;
        }

        return false;
    }

    /**
     * Create empty active user
     *
     * @return User
     */
    public function createEmptyActiveUser()
    {
        $user = $this->createEmptyUser();
        $user->setIsActive(true);
        $user->setPasswordUnencoded(uniqid('pwd'));

        return $user;
    }

    /**
     * @param integer   $token
     * @return boolean
     * @throws \InvalidArgumentException
     */
    private function isPasswordResettingExpired($token)
    {
        $ttl = $this->getPasswordResettingTtl();

        if (!is_numeric($token)) {
            throw new \InvalidArgumentException('token has to be a numeric');
        }

        return ((int) $token + $ttl < time());
    }

    /**
     * @return integer
     */
    private function getPasswordResettingTtl()
    {
        return $this->passwordResettingTtl;
    }

    /**
     * @return UserRepositoryInterface
     */
    private function getUserRepository()
    {
        return $this->userRepository;
    }

}
