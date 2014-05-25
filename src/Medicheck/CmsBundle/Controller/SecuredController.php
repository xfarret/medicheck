<?php

namespace Medicheck\CmsBundle\Controller;

use Medicheck\CmsBundle\Form\Account;
use Medicheck\CmsBundle\Form\Recipient;
use Medicheck\CmsBundle\Form\Type\AccountType;
use Medicheck\UserBundle\Entity\User;
use Medicheck\UserBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SecuredController
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

        $form = $this->createForm(new AccountType(), $user);

        if($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ( $form->isValid() ) {
                $data = $form->getData();
            }
        }

        return $this->render('MedicheckCmsBundle:Secured:account.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }
}