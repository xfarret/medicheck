<?php

namespace Medicheck\UserBundle\Controller;

use Medicheck\UserBundle\FormType\LoginType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * @Route("/", defaults={"_locale"="fr"}, requirements={"_locale"="fr"})
 */
class SecurityController extends Controller {

    /**
     * Pour que login soit en page d'accueil -> Route("/"), sinon Route("/login")
     * @Route("/", name="login")
     * @Method({"GET"})
     * @Template()
     */
    public function loginAction(Request $request)
    {

        $session = $request->getSession();
        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        $form = $this->createForm(new LoginType(), array('username' => $session->get(SecurityContext::LAST_USERNAME)));

        return array(
            'error'	=> $error,
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/login_check", name="login_check")
     */
    public function checkAction()
    {
        throw new RuntimeException('You must configure the check path to be handled by the firewall using form_login in your security firewall configuration.');
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
        throw new RuntimeException('You must activate the logout in your security firewall configuration.');
    }
} 