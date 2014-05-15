<?php

namespace Medicheck\CmsBundle\Controller;

use Medicheck\UserBundle\Entity\User;
use Medicheck\UserBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ConnectedController
 * @package Medicheck\CmsBundle\Controller
 *
 * @Route("/secured", defaults={"_locale"="fr"}, requirements={"_locale"="fr"})
 */
class SecuredController extends Controller {

    /**
     * @Route("/", name="logged_homepage")
     * @Method({"GET"})
     */
    public function homePageAction(Request $request)
    {
        $user = $this->container->get('security.context')->getToken()->getUser();

        return $this->render('MedicheckCmsBundle:Secured:homepage.html.twig', array('user' => $user));
    }

    /**
     * @Route("/paiements", name="logged_input")
     * @Method({"GET"})
     */
    public function dataInputAction(Request $request)
    {
        $user = $this->container->get('security.context')->getToken()->getUser();

        return $this->render('MedicheckCmsBundle:Secured:paiements.html.twig', array('user' => $user));
    }

    /**
     * @Route("/account", name="logged_account")
     * @Method({"GET", "POST"})
     */
    public function accountAction(Request $request) {
        $user = $this->container->get('security.context')->getToken()->getUser();

        $form = $this->createForm(new UserType(), $user);
        $form->remove('roles');

        $recipient = new User();
        $formRecipient = $this->createForm(new UserType(), $recipient);
        $formRecipient->remove('passwordUnencoded');
        $formRecipient->remove('email');

        if($request->isMethod('POST')) {
            $form->handleRequest($request);
            $formRecipient->handleRequest($request);
        }

        return $this->render('MedicheckCmsBundle:Secured:account.html.twig',
            array(
                'form' => $form->createView(),
                'formRecipient' => $formRecipient->createView(),
                'user' => $user
            )
        );
    }
}