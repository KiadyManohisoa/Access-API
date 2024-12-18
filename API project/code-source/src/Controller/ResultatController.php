<?php

namespace App\Controller;

use App\Model\Etudiant;
use App\Model\Semestre;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\UtilDB;
use App\Service\ResponseFormatter;
use Symfony\Component\HttpFoundation\Response;

class ResultatController extends AbstractController
{
    #[Route('/etudiants/{etudiantId}/resultats/{semestreId}', methods: ['GET'])]
    public function getResultat(string $etudiantId, string $semestreId, UtilDB $utilDB): Response
    {
        $response=null;
        $status = '';
        $error = null;
        $etudiant = new Etudiant($etudiantId);
        $semestre = new Semestre($semestreId);
        $responseFormatter = new ResponseFormatter();

        try {
            $connection = $utilDB->getConnection();
            $etudiant->checkExistence($connection);
            $response = $etudiant->getResultatSemestre($connection, $semestre);
            $status = "success";
        }
        catch(\Exception $e) {
            $status = "error";
            $error = $e->getMessage();
            //echo json_encode($e->getTrace());
        }
        return $responseFormatter->formatResponsetoJson($response,$status,$error);
    }
}