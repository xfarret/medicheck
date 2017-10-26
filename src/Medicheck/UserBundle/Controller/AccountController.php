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
use Medicheck\UserBundle\Form\Model\RegisterUserModel;
use Medicheck\UserBundle\Form\Type\RegisterUserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
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
        $user = new RegisterUserModel();
        $form = $this->createForm(RegisterUserType::class, $user, array());
//        $form->remove('roles');

        if($request->isMethod('POST')) {
            $form->handleRequest($request);

            if( $form->isValid() ) {
                $translator = $this->get('translator');
                try {
                    $emUserManager = $this->get('medicheck.manager.user');
                    $result = $emUserManager->createUser($user);
                } catch (\Exception $e) {
                    $result = false;
                }

                if ( $result ) {
                    $request->getSession()->getFlashBag()->add('info',
                        $translator->trans('register.done', array(), 'register')
                    );
                } else {
                    $request->getSession()->getFlashBag()->add('danger',
                        $translator->trans('register.error', array(), 'register')
                    );
                }

                return $this->redirect($this->generateUrl('login'));
            }
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