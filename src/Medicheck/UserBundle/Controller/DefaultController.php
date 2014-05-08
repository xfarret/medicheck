<?php

namespace Medicheck\UserBundle\Controller;

use Medicheck\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    /**
     * @Route("/init")
     */
    public function initAction()
    {
        $user = new User();
        $user->setNumSecu("171057511211572");
        $user->setFirstname("Xavier");
        $user->setLastname("Farret");
        $user->setEmail("xfarret@gmail.com");
        $user->setIsActive(true);
        $user->setPasswordUnencoded("userpass");

        $userManager = $this->get('medicheck.manager.user');
        $userManager->updateUser($user);

        $response = new JsonResponse();
        $response->setData(array('user' => $user));
        return $response;
    }
}
