<?php

namespace App\Service;

use Doctrine\DBAL\Connection;
use App\Service\NiveauService;
use Exception;

class EtudiantService
{

    private NiveauService $niveauService;
    public function __construct(NiveauService $niveauService)
    {
        $this->niveauService = $niveauService;
    }

    public function findById(Connection $connection, string $idEtudiant): ?array
    {
        $sql = 'SELECT * FROM etudiant WHERE id = :idEtudiant';

        // Préparer et exécuter la requête
        $stmt = $connection->prepare($sql);
        $stmt->bindValue('idEtudiant', $idEtudiant);
        $results = $stmt->executeQuery();

        // Retourner les données sous forme de tableau associatif
        return $results->fetchAllAssociative() ?: null;
    }

    public function getNoteByIdEtudiantBySemestre(Connection $connection, string $idEtudiant, string $idSemestre) :?array 
    {
        $sql = 'SELECT * FROM v_notes_inscription_sessionSemetre_details WHERE idEtudiant = :idEtudiant and idSemestre = :idSemestre';

        // Préparer et exécuter la requête
        $stmt = $connection->prepare($sql);
        $stmt->bindValue('idEtudiant', $idEtudiant);
        $stmt->bindValue('idSemestre', $idSemestre);
        $results = $stmt->executeQuery();

        // Retourner les données sous forme de tableau associatif
        return $results->fetchAllAssociative() ?: null;

    }

    public function getNoteByIdEtudiantByNiveau(Connection $connection, string $idEtudiant, string $idNiveau) :?array 
    {
        $niveau = new NiveauService();
        $semestres = $this->niveauService->getSemestreByIdNiveau($connection, $idNiveau);

        $results = [];
         
        if(is_array($semestres)) {
            foreach ($semestres as $semestre) {
                $results[$semestre['id']] = $this->getNoteByIdEtudiantBySemestre($connection, $idEtudiant, $semestre['id']);
            }
        } else throw new Exception('Ce semestre n\'existe pas encore');
       

        if(!is_array($results) or count($results)==0)  throw new Exception("Il n'y a pas de note pour cet élève pour le niveau ".$idNiveau);
        
        return $results ;
    }



}

?>
