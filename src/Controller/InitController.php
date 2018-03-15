<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class InitController extends Controller
{
    /**
     * @Route("/init/users", name="init_users")
     */
    public function initUsersAction(Request $request) {
        $userManager = $this->get('medicheck.manager.user');

        $user = $userManager->getUserByUsername('123');
        $response = new JsonResponse($user);

        return $response;
    }
}
