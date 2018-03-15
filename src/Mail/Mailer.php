<?php
/**
 * Created by PhpStorm.
 * User: xfarret
 * Date: 27/05/14
 * Time: 10:55
 */

namespace App\Mail;

use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Translation\TranslatorInterface;

class Mailer {

    private $swiftInstance;
    private $mailer;
    private $templating;
    private $translator;
    private $from;

    public function __construct($mailer, $from, EngineInterface $templating, TranslatorInterface $translator)
    {
        $this->mailer = $mailer;
        $this->from = $from;
        $this->templating = $templating;
        $this->translator = $translator;

    }

    /**
     * @param string $to
     * @param string $subject
     * @param string $templateBodyHtml
     * @param array $parameters
     */
    public function sendHTMLMessage($to, $subject, $templateBodyHtml, $parameters)
    {
        $mail = $this->getMailerInstance();

        $mail
            ->setSubject($subject)
            ->setFrom($this->from)
            ->setTo($to)
            ->setBody($this->templating->render($templateBodyHtml, $parameters), 'text/html')
            ->setContentType('text/html');

        $this->mailer->send($mail);
    }

    /**
     * @param string $to
     * @param string $subject
     * @param string $templateBodyHtml
     * @param array $parameters
     */
    public function sendTxtMessage($to, $subject, $templateBodyHtml, $parameters)
    {
        $mail = $this->getMailerInstance();

        $mail
            ->setSubject($subject)
            ->setFrom($this->from)
            ->setTo($to)
            ->setBody($this->templating->render($templateBodyHtml, $parameters), 'text/plain');

        $this->mailer->send($mail);
    }

    /**
     * @param string $to
     * @param string $subject
     * @param string $templateBodyHtml
     * @param string $templateBodyText
     * @param array $parameters
     */
    public function sendMessage($to, $subject, $templateBodyHtml, $templateBodyText, $parameters)
    {
        $mail = $this->getMailerInstance();

        $mail
            ->setSubject($subject)
            ->setFrom($this->from)
            ->setTo($to)
            ->setBody($this->templating->render($templateBodyHtml, $parameters), 'text/html')
            ->addPart($this->templating->render($templateBodyText, $parameters), 'text/plain');

        $this->mailer->send($mail);
    }

    // PRIVATE METHODS

    /**
     * @return \Swift_Message
     */
    private function getMailerInstance()
    {
        if ( !isset($this->swiftInstance) ) {
            $this->swiftInstance = new \Swift_Message();
        }

        return $this->swiftInstance;
//        return \Swift_Message::newInstance();
    }
}