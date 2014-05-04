<?php
/**
 * Created by PhpStorm.
 * User: xavier
 * Date: 04/05/14
 * Time: 21:13
 */

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
     * @var UserRepositoryInterface
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

    public function getUserById($id)
    {
        return $this->getUserRepository()->findOneBy(array('id' => $id));
    }

    public function getUserByUsername($username)
    {
        return $this->getUserRepository()->loadUserByUsername($username);
    }

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

    public function removeUser(User $user)
    {
        $this->userRepository->remove($user);
    }

    public function toggle(User $user)
    {
        $user->setIsActive(!$user->getIsActive());

        $this->getUserRepository()->save($user);

        return $this;
    }

    public function isActive(User $user)
    {
        return $user->getIsActive();
    }

    /**
     *
     * @param User  $user
     * @return string
     *
     * @throw ResettingPasswordAlreadyDoneException
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
     *
     * @param User      $user
     * @param string    $secret
     * @param string    $plainPassword
     *
     * @throw ResettingPasswordInvalidSecretException
     * @throw ResettingPasswordExpiredException
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
     *
     * @param \Medicheck\UserBundle\Entity\User $user
     * @param string $passwordToValid
     * return boolean
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
