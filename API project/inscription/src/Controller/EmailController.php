<?php

namespace App\Controller;

use App\Service\EmailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmailController extends AbstractController
{
    // #[Route("/mail", methods: "GET")]

    // public function testEmail(EmailService $emailService): Response
    // {
    //     $emailService->sendTestEmail('miaouh@example.com');
    //     return new Response('Email envoyé via MailHog !');
    // }

    private EmailService $emailService;
    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    #[Route("/mail", methods: "GET")]
    public function sendInvitation(): Response
    {
        $recipient = 'invite@example.com'; // Remplacez par une adresse réelle
        $headerImagePath = 'https://i.pinimg.com/736x/40/6f/6c/406f6c8fc795fb9186eaa1195a677df0.jpg'; // Chemin vers l'image

        // Utiliser le service pour envoyer l'email
        $this->emailService->sendGalaInvitation($recipient, $headerImagePath);

        return new Response('Invitation envoyée avec succès.');
    }
}
