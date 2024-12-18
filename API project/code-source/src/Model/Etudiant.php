<?php

namespace App\Model;

use PDO;
use App\Model\NoteMatiere;
use App\Model\ResultatSemestre;
use DateTime;

class Etudiant
{
    private string $etu;
    private string $nom;
    private string $prenom;
    private \DateTime $dateNaissance;

    public function __construct(string $etu='', string $nom='', string $prenom='', \DateTime $dateNaissance=new DateTime())
    {
        $this->etu = $etu;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->dateNaissance = $dateNaissance;
    }

    public function checkExistence(PDO $co) {
        $query = "select * from etudiant where etu = :etudiantId";
        $etudiantId = $this->getEtu();
        try {
            $stmt = $co->prepare($query);
            $stmt->bindParam(':etudiantId', $etudiantId, PDO::PARAM_STR);
            $stmt->execute();
            if($stmt->rowCount()==0) {
                throw new \Exception("Etudiant introuvable avec l'ETU ".$etudiantId);
            }
        }
        catch (\Exception $e) {
            throw $e;
        }
    }

    public function getResultatSemestre(PDO $co, Semestre $semestre): ?ResultatSemestre
    {
        $resultat = null;
        $query = " select * from noteSemestreEtudiant(:etudiantId, :semestreId) ";
        $etudiantId = $this->getEtu();
        $semestreId = $semestre->getId();
        try {
            $stmt = $co->prepare($query);
            $stmt->bindParam(':etudiantId', $etudiantId, PDO::PARAM_STR);
            $stmt->bindParam(':semestreId', $semestreId, PDO::PARAM_STR);
            $stmt->execute();

            $resultat = new ResultatSemestre();
            $noteMatieres = [];

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $noteMatieres[] = new NoteMatiere(
                    $row['ue'], 
                    $row['nom'], 
                    (int)$row['credit'], 
                    (float)$row['valeurnote'], 
                    new \DateTime($row['datesession'])
                );
            }

            $resultat->setNoteMatieres($noteMatieres);

        } catch (\Exception $e) {
            throw $e;
        }
        return $resultat;

    }

    public function getEtu(): string
    {
        return $this->etu;
    }

    public function setEtu(string $etu): self
    {
        $this->etu = $etu;
        return $this;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function getDateNaissance(): \DateTime
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTime $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;
        return $this;
    }
}
