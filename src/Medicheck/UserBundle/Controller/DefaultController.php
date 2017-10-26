<?php

namespace Medicheck\UserBundle\Controller;

use Medicheck\UserBundle\Entity\User;
use Medicheck\UserBundle\Entity\Role;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
	/**
     * @Route("/initRole")
     */
    public function initRoleAction()
    {
    	$roleRepository = $this->get('Medicheck\UserBundle\Entity\RoleRepository');

    	$role = new Role();
    	$role->setName('ADMIN');
    	$role->setRole('ROLE_ADMIN');
        $roleRepository->saveOrUpdate($role);
        
        $role = new Role();
    	$role->setName('USER');
    	$role->setRole('ROLE_USER');
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
        $user->setNumSecu("171057511211572");
        $user->setFirstname("Xavier");
        $user->setLastname("Farret");
        $user->setEmail("xfarret@gmail.com");
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
