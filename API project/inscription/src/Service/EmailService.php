<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class EmailService
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendGalaInvitation(string $to, string $headerImagePath): void
    {
        // Créer l'email
        $email = (new TemplatedEmail())
            ->from('symfony@example.com')
            ->to($to)
            ->subject('Invitation au Gala de Noël')
            ->htmlTemplate('emails/page.html.twig')
            ->context([])
            ->embed(fopen($headerImagePath, 'r'), 'header_image'); // Image en CID

        // Envoyer l'email
        $this->mailer->send($email);
    }
}
