<?php

namespace Medicheck\UserBundle\Controller;

use Medicheck\UserBundle\Entity\User;
use Medicheck\UserBundle\Entity\UserRole;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
	/**
     * @Route("/initRole")
     */
    public function initRoleAction()
    {
    	$roleRepository = $this->get('Medicheck\UserBundle\Entity\RoleRepository');

    	$role = new UserRole('ROLE_ADMIN');
    	$role->setName('ADMIN');
        $roleRepository->saveOrUpdate($role);
        
        $role = new UserRole('ROLE_USER');
    	$role->setName('USER');
        $roleRepository->saveOrUpdate($role);

        $response = new JsonResponse();
        $response->setData(array('roles' => 'done'));
        return $response;
    }
    
    /**
     * @Route("/initUser")
     */
    public function initUserAction()
    {
        $roleRepository = $this->get('Medicheck\UserBundle\Entity\RoleRepository');
        $role = $roleRepository->getRoleByName("USER");

        $user = new User();
        $user->setNumSecu("123");
        $user->setFirstname("Xavier");
        $user->setLastname("Farret");
        $user->setEmail("xfarret@medicheck.fr");
        $user->setIsActive(true);
        $user->setPasswordUnencoded("userpass");
        $user->addRole($role);

        $userManager = $this->get('medicheck.manager.user');
        $userManager->updateUser($user);

        $response = new JsonResponse();
        $response->setData(array('user' => $user));
        return $response;
    }
}
