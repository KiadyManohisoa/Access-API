<?php

namespace App\Service;

use App\Exception\Mail\MailIntrouvableException;
use App\Exception\Mail\MailNonEnvoyeException;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ServiceMail
{
    public static string  $apiKey = "4784f2b9e9f0436791203b1c2c16bbe8";
    public static string $urlVerification = "https://emailvalidation.abstractapi.com/v1/";

    public static string  $delivrabitilite = "DELIVERABLE";            // valeur de réponse par défaut

    private $mailer;
    private $client;

    public function __construct(MailerInterface $mailer, HttpClientInterface $client)
    {
        $this->mailer = $mailer;
        $this->client = $client;
    }
    function estValide(string $email): bool
    {
        try {
            $url = self::$urlVerification;

            $reponse = $this->client->request('GET', $url, [
                'query' => [
                    'api_key' => self::$apiKey, 
                    'email' => $email,
                ],
            ]);
            $statusCode = $reponse->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 300) {

                $reponseTab =  $reponse->toArray(); 
                if($reponseTab['deliverability']==self::$delivrabitilite) return true ;
                
                else throw new MailIntrouvableException("Le mail n'a pas été trouvé", $email);
            }

            throw new \RuntimeException("Réponse invalide du web service : Code $statusCode");

        } catch (TransportExceptionInterface | ClientExceptionInterface | ServerExceptionInterface | RedirectionExceptionInterface $e) {

            throw new \RuntimeException("Impossible d\'envoyer la requête au web service. : '{$e}'", 0, $e);
        }
    }

    function envoyerMail(string $recepteur, string $url): void{

        $email = (new Email())
            ->from('accessAPI@monfournisseur.com')  // Utilise un adresse email dédiée pour l'envoi
            ->to($recepteur)
            ->subject('Confirmez votre adresse email')
            ->html("<p>Affirmer votre inscription avec ACCESS-API : <a href=google.com>Confirmer '{$url}'</a></p>");

        try {

            $this->mailer->send($email);

        } catch (TransportExceptionInterface $e) {

            throw new MailNonEnvoyeException('Impossible d\'envoyer l\'email.', $e); // Gestion d'erreur personnalisée
        } catch (\Exception $e) {

            throw new \RuntimeException("Une erreur inattendue est survenue lors de l\'envoi de l\'email: '{$e}'");
        }
    }


} ?>