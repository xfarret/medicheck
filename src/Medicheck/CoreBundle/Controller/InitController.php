<?php

namespace Medicheck\CoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class InitController extends Controller {

    /**
     * @Route("/init/users")
     */
    public function initUsersAction(Request $request) {
        $userManager = $this->get('medicheck.manager.user');

        $user = $userManager->getUserByUsername('123');
        $response = new JsonResponse($user);

        return $response;
    }
} 