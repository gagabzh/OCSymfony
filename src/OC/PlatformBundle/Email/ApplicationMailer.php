<?php
/**
 * Created by PhpStorm.
 * User: bgarnier
 * Date: 14/02/2018
 * Time: 11:14
 */

namespace OC\PlatformBundle\Email;

use OC\PlatformBundle\Entity\Application;

class ApplicationMailer
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendNewNotification(Application $application)
    {
        $message = new \Swift_Message(
            'Nouvelle candidature',
            'Vous avez reçu une nouvelle candidature.'
        );

        $message
            ->addTo($application->getAdvert()->getEmail()) // Ici bien sûr il faudrait un attribut "email", j'utilise "author" à la place
            ->addFrom('bgarnier@aneo.fr')
        ;
// TODO uncomment this line when emailing was working
//        $this->mailer->send($message);
    }
}
