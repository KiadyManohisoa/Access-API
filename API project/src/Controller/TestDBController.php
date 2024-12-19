<?php

namespace App\Controller;

use App\Service\UtilDB;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Connection;

class TestDBController extends AbstractController
{

    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    #[Route('/test-db', name: 'test_db')]
    public function testDatabase(): JsonResponse
    {
        try {
            $theconnection = $this->connection;
            return new JsonResponse(['message' => 'Connexion réussie à la base de données']);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }
    }
}
