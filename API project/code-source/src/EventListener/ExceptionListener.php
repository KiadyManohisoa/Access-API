<?php 
namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

// class ExceptionListener
// {
    // public function onKernelException(ExceptionEvent $event)
    // {
    //     $exception = $event->getThrowable();

    //     // Préparer la structure de la réponse
    //     $error = [
    //         'error' => [
    //             'code' => $this->getStatusCode($exception),
    //             'message' => $exception->getMessage(),
    //             'details' => $exception->getMessage(),
    //         ],
    //     ];

    //     // Créer la réponse JSON
    //     $response = new JsonResponse($error, $this->getStatusCode($exception));

    //     // Remplacer la réponse par défaut
    //     $event->setResponse($response);
    // }

    // private function getStatusCode(\Throwable $exception): int
    // {
    //     // Si l'exception est de type HttpException, obtenir le code HTTP
    //     if ($exception instanceof HttpExceptionInterface) {
    //         return $exception->getStatusCode();
    //     }

    //     // Code par défaut pour une exception non HTTP
    //     return 500;
    // }

    // private function getExceptionDetails(\Throwable $exception): array
    // {
    //     // Ajoutez ici des détails personnalisés si disponibles
    //     if (method_exists($exception, 'getDetails')) {
    //         return $exception->getDetails(); // Assurez-vous que l'exception a cette méthode
    //     }

    //     return []; // Détails par défaut
    // }
// }
