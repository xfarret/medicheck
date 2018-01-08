<?php
/**
 * Created by PhpStorm.
 * User: xavier
 * Date: 11/05/14
 * Time: 17:43
 */

namespace Medicheck\UserBundle\Controller;

use Medicheck\UserBundle\Form\Model\RegisterUserModel;
use Medicheck\UserBundle\Form\Type\RegisterUserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

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

    /**
     * @Route("/forget", name="forget_password")
     * @Method({"GET", "POST"})
     */
    public function forgetPasswordAccountAction(Request $request) {
        $form = $this->createFormBuilder()
            ->add('email', EmailType::class, array(
                'label'                 => 'email.label',
                'required'              => true,
                'translation_domain'    => 'login'
                )
            )
            ->getForm();

        if ( $request->isMethod('POST') ) {
            $form->handleRequest($request);

            if ( $form->isValid() ) {
                $data = $form->getData();
                $email = $data['email'];
                $translator = $this->get('translator');
                $mailer = $this->get('core.mailer');

                $mailer->sendMessage(
                    $email,
                    $translator->trans('email.reset.email.title', array(), 'login'),
                    '@MedicheckCore/Emails/email_reset_password.html.twig',
                    '@MedicheckCore/Emails/email_reset_password.txt.twig',
                    array(
                        'link_reset'    => "http:" . $this->generateUrl(
                            'reset_password',
                            array('email' => $email),
                            UrlGeneratorInterface::NETWORK_PATH
                        )
                    )
                );
                return $this->render('@MedicheckUser/Account/lost_password.html.twig', array(
                    'form'              => $form->createView(),
                    'password_sent'     => true
                ));
            }
        }

        return $this->render('@MedicheckUser/Account/lost_password.html.twig', array(
           'form' => $form->createView()
        ));
    }

    /**
     * @Route("/reset/{email}", name="reset_password")
     * @Method({"GET"})
     */
    public function resetPasswordAction(Request $request, $email) {

    }

    public function updateAccountAction() {

    }

    public function deleteAccountAction() {

    }

    public function updatePasswordAction() {

    }

} 