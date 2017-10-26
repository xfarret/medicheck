<?php

namespace Medicheck\CmsBundle\Controller;

use Medicheck\CmsBundle\Entity\Paiement;
use Medicheck\CmsBundle\Form\Account;
use Medicheck\CmsBundle\Form\Model\PaiementModel;
use Medicheck\CmsBundle\Form\Recipient;
use Medicheck\CmsBundle\Form\Type\AccountType;
use Medicheck\CmsBundle\Form\Type\PaiementType;
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
 * @Route("/__secured__")
 */
class SecuredController extends Controller {

    /**
     * @Route("/", name="logged_homepage")
     * @Method({"GET"})
     */
    public function homePageAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();

        return $this->render('MedicheckCmsBundle:Secured:homepage.html.twig', array('user' => $user));
    }

    /**
     * @Route("/paiements", name="logged_input")
     * @Method({"GET"})
     */
    public function dataInputAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $paiementManager = $this->get('medicheck.manager.paiement');
        $paiements = $paiementManager->getRepository()->getPaiements($user);

        $form = $this->createForm(PaiementType::class, new PaiementModel(), array());

        $params = array(
            'form'      => $form->createView(),
            'paiements' => $paiements,
            'user'      => $user
        );

        return $this->render('MedicheckCmsBundle:Secured:paiements.html.twig', $params);
    }

    /**
     * @Route("/account", name="logged_account")
     * @Method({"GET", "POST"})
     */
    public function accountAction(Request $request) {
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $form = $this->createForm(AccountType::class, $user, array());

        if($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ( $form->isValid() ) {
                $userManager = $this->get('medicheck.manager.user');
                $userManager->updateUser($user);
            }
        }

        return $this->render('MedicheckCmsBundle:Secured:account.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }
}