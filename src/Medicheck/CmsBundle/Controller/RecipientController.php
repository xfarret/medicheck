<?php
/**
 * Created by PhpStorm.
 * User: xavier
 * Date: 21/05/14
 * Time: 22:23
 */

namespace Medicheck\CmsBundle\Controller;

use Medicheck\UserBundle\Entity\User;
use Medicheck\UserBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RecipientController
 * @package Medicheck\CmsBundle\Controller
 *
 * @Route("/secured", defaults={"_locale"="fr"}, requirements={"_locale"="fr"})
 */
class RecipientController extends Controller {

    /**
     * @Route("/recipient/add", name="logged_add_recipient")
     * @Method({"POST"})
     */
    public function addRecipientAction(Request $request) {
        $user = $this->container->get('security.context')->getToken()->getUser();

        $recipient = new User();
        $formRecipient = $this->createForm(new UserType(), $recipient);
        $formRecipient->remove('passwordUnencoded');
        $formRecipient->remove('email');

        return $this->renderView('MedicheckCmsBundle:Secured:recipients.html.twig',
            array(
                'formRecipient' => $formRecipient->createView(),
                'user' => $user
            )
        );
    }

    /**
     * @Route("/recipient/del", name="logged_del_recipient")
     * @Method({"POST"})
     */
    public function deleteRecipientAction() {

    }
} 