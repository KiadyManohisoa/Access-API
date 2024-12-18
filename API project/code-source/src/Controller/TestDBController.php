<?php

namespace App\Controller;

use App\Service\UtilDB;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TestDBController extends AbstractController
{
    #[Route('/test-db', name: 'test_db')]
    public function testDatabase(UtilDB $utilDB): JsonResponse
    {
        try {
            $connection = $utilDB->getConnection();
            return new JsonResponse(['message' => 'Connexion réussie à la base de données']);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }
    }
}
