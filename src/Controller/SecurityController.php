<?php

namespace App\Controller;

use App\Form\Type\LoginType;
use App\Form\Model\LoginModel;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route("/")
 */
class SecurityController extends Controller {

    /**
     * Pour que login soit en page d'accueil -> Route("/"), sinon Route("/login")
     * @Route("/login", name="login")
     * @Method({"GET"})
     */
    public function loginAction(Request $request, AuthenticationUtils $authUtils)
    {
        // get the login error if there is one
        $error = $authUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();

        $loginModel = new LoginModel();
        $loginModel->setUsername($lastUsername);

        $form = $this->createForm(LoginType::class, $loginModel, array());

        $params = array(
            'error' => $error,
            'form'  => $form->createView()
        );

        return $this->render('Security/login.html.twig', $params);
    }

    /**
     * @Route("/login_check", name="login_check")
     */
    public function checkAction()
    {
        throw new \RuntimeException('You must configure the check path to be handled by the firewall using form_login in your security firewall configuration.');
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
        throw new \RuntimeException('You must activate the logout in your security firewall configuration.');
    }
} 