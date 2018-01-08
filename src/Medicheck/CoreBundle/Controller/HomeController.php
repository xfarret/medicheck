<?php
/**
 * Copyright @Xavier Farret
 * User: xfarret
 * Date: 08/01/18
 * Time: 11:39
 */

namespace Medicheck\CoreBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{

    /**
     * @Route("/", name="homepage")
     * @Method({"GET"})
     */
    public function homepageAction(Request $request) {
        return $this->redirect($this->generateUrl('login'));
    }
}