<?php

namespace Medicheck\CmsBundle\Controller;

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

        return $this->render('MedicheckCmsBundle:Secured:homepage.html.twig', array());
    }
} 