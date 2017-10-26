<?php

namespace Medicheck\UserBundle\Manager;

use Medicheck\UserBundle\Entity\Role;
use Medicheck\UserBundle\Entity\RoleRepository;
use Medicheck\UserBundle\Entity\User;
use Medicheck\UserBundle\Exception\UpdateException;
use Medicheck\UserBundle\Entity\UserRepository;
use Medicheck\UserBundle\Exception\ResettingPasswordExpiredException;
use Medicheck\UserBundle\Exception\ResettingPasswordInvalidSecretException;
use Medicheck\UserBundle\Exception\ResettingPasswordAlreadyDoneException;
use Medicheck\UserBundle\Form\Model\RegisterUserModel;
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

    /**
     * @var RoleRepository
     */
    private $roleRepository;

    /**
     * @var RecipientManager
     */
    private $recipientManager;

    public function __construct(EncoderFactoryInterface $encoderFactory, UserRepository $userRepository, RoleRepository $roleRepository, RecipientManager $recipientManager, $passwordResettingTtl)
    {
        if (!is_numeric($passwordResettingTtl)) {
            throw new \InvalidArgumentException('password resetting ttl has to be a numeric');
        }

        $this->encoderFactory = $encoderFactory;
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->passwordResettingTtl = (int) $passwordResettingTtl;
        $this->recipientManager = $recipientManager;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getUserById($id)
    {
        return $this->userRepository->findOneBy(array('id' => $id));
    }

    /**
     * @param $username
     * @return mixed
     */
    public function getUserByUsername($username)
    {
        return $this->userRepository->loadUserByUsername($username);
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
            $this->recipientManager->removeRecipients($user);
            return true;
        } catch (\Exception $e) {
            throw new UpdateException('error.persist.user', 201, $e);
        }
    }

    /**
     * @param RegisterUserModel $registerUser
     * @param Role $role
     * @return bool
     */
    public function createUser(RegisterUserModel $registerUser, Role $role = null) {
        if ( $role == null ) {
            $role = $this->roleRepository->getDefaultRoleUser();
        }

        $user = new User();
        $user->setNumSecu($registerUser->getNumsecu());
        $user->setFirstname($registerUser->getFirstname());
        $user->setLastname($registerUser->getLastname());
        $user->setEmail($registerUser->getEmail());
        $user->setPasswordUnencoded($registerUser->getPasswordUnencoded());
        $user->setIsActive(true);
        $user->setLocked(false);
        $user->addRole($role);

        try {
            return $this->updateUser($user);
        } catch ( \Exception $e ) {
            return false;
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

        $this->userRepository->save($user);

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
        $ttl = $this->passwordResettingTtl;

        if (!is_numeric($token)) {
            throw new \InvalidArgumentException('token has to be a numeric');
        }

        return ((int) $token + $ttl < time());
    }

}
