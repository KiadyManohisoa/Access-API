<?php

namespace App\Service;

use App\Model\Exception\MailIntrouvableException;
use App\Model\Exception\MailInvalideException;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class ServiceMail
{
    private MailerInterface $mailer;
    function estMailValide(string $email): bool
    {
        // Expression régulière pour valider la syntaxe d'un e-mail
        $pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
        
        return (bool)preg_match($pattern, $email);
    }

    public function verifierMail(string $email, string $lien): void
    {

        if (!$this->estMailValide($email)) {
            throw new MailInvalideException("L'adresse e-mail '{$email}' est invalide.",$email );
        }

        // try {
        //     if (rand(0, 9) < 1) {
        //         throw new MailIntrouvableException("Impossible d'envoyer l'e-mail à '{$email}'.", $email);
        //     }
        // }

    }

    public function envoyerMail(string $email, string $lien): void{

        // // Créer l'email
        // $email = (new TemplatedEmail())
        // ->from('symfony@example.com')
        // ->to($to)
        // ->subject('Invitation au Gala de Noël')
        // ->htmlTemplate('emails/page.html.twig')
        // ->context([])
        // ->embed(fopen($headerImagePath, 'r'), 'header_image'); // Image en CID

        // // Envoyer l'email
        //  $this->mailer->send($email);
    }


} ?>