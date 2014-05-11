<?php
/**
 * Created by PhpStorm.
 * User: xavier
 * Date: 11/05/14
 * Time: 17:43
 */

namespace Medicheck\UserBundle\Controller;

use Medicheck\UserBundle\Entity\User;
use Medicheck\UserBundle\Entity\Role;
use Medicheck\UserBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/", defaults={"_locale"="fr"}, requirements={"_locale"="fr"})
 */
class AccountController extends Controller {

    /**
     * @Route("/register", name="register")
     * @Method({"GET", "POST"})
     */
    public function createAccountAction(Request $request) {
        $user = new User();
        $user->setNumSecu("");
        $user->setLastname("");
        $user->setFirstname("");

        $form = $this->createForm(new UserType(), $user);
        $form->remove('roles');

        if($request->isMethod('POST')) {

        }

        return $this->render('MedicheckUserBundle:Account:create.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function updateAccountAction() {

    }

    public function deleteAccountAction() {

    }

    public function updatePasswordAction() {

    }

} 