<?php

namespace App\Model;

use DateTime;
use Doctrine\DBAL\Connection;

class Tentative
{

    public int $nombre;
    public DateTime $dateDisponibilite;
    public string $idCompte;

    public function insert(Connection $connection): void
    {
        $idCompte = $this->getIdCompte(); 

        // Insérer dans la table `tentative`
        $connection->insert(
            'tentative',  // Nom de la table
            [
                'idcompte' => $idCompte,  
                'date_tentative' => (new DateTime())->format('Y-m-d H:i:s'),  
            ]
        );
    }


    public function __construct(int $nombre=0, \DateTime $dateDisponibilite=new DateTime(), string $idCompte = '')
    {
        $this->nombre = $nombre;
        $this->dateDisponibilite = $dateDisponibilite;
        $this->idCompte = $idCompte;
    }

    public function getIdCompte() {
        return $this->idCompte;
    }

    public function setIdCompte(string $idCompte) {
        $this->idCompte = $idCompte;
    }

    
    public function getNombre(): int
    {
        return $this->nombre;
    }

    public function setNombre(int $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function getDateDisponibilite(): DateTime
    {
        return $this->dateDisponibilite;
    }

    public function setDateDisponibilite(DateTime $dateDisponibilite): void
    {
        $this->dateDisponibilite = $dateDisponibilite;
    }
}
