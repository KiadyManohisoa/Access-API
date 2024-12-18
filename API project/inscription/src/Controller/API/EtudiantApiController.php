<?php 


namespace App\Controller\API;

use App\Service\EtudiantService;
use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

// pour le model 
use App\Model\ModelRender ;

class EtudiantApiController extends AbstractController
{
    private EtudiantService $etudiantService;
    private Connection $connection ;

    private ModelRender $model ; 

    public function __construct(Connection $connection, EtudiantService $etudiantService)
    {
        $this->etudiantService = $etudiantService;
        $this-> connection = $connection ;
        $this->model = new ModelRender();
    }

    
    #[Route("/api/etudiants/{id}", methods: "GET")]
    public function findByIdEtudiant(string $id): JsonResponse
    {
        $etudiant = $this->etudiantService->findById($this->connection, $id);

        if ($etudiant != null) {
            return $this->model->render(200, null, $etudiant);
        } else {
            return $this->model->render(400, "L'etudiant n'a pas été trouvé", null);

        }
    }

    #[Route("/api/etudiants/{id}/semestre/{idSemestre}", methods: "GET")]
    public function findByIdEtudiantBySemestre(string $id, string $idSemestre): JsonResponse
    {
        $etudiant = $this->etudiantService->getNoteByIdEtudiantBySemestre($this->connection, $id, $idSemestre);

        if ($etudiant != null) {
            return $this->model->render(200, null, $etudiant);

        } else {
            return $this->model->render(400, "L'etudiant n'a pas été trouvé", null);

        }
    }

    #[Route("/api/etudiants/{id}/niveau/{idNiveau}", methods: "GET")]
    public function findByIdEtudiantByNiveau(string $id, string $idNiveau): JsonResponse
    {

        try {
            $etudiant = $this->etudiantService->getNoteByIdEtudiantByNiveau($this->connection, $id, $idNiveau);

            return $this->model->render(200, null, $etudiant);

        } catch (Exception $e) {
            // Attraper et traiter l'exception
            return $this->model->render(400, $e->getMessage(), null);

        }
    }
}


