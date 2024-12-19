<?php

namespace App\Model;

use DateTime;
use Doctrine\DBAL\Connection;


class Tentative
{
    public int $nombre;
    public DateTime $dateDisponibilite;
    public Compte $compte;

    public function insert(Connection $connection): void
    {
        $idCompte = $this->getCompte()->getId(); 

        // Insérer dans la table `tentative`
        $connection->insert(
            'tentative',  // Nom de la table
            [
                'idcompte' => $idCompte,  
                'date_tentative' => (new DateTime())->format('Y-m-d H:i:s'),  
            ]
        );
    }


    public function __construct(int $nombre=0, \DateTime $dateDisponibilite=new DateTime(), Compte $compte = new Compte())
    {
        $this->nombre = $nombre;
        $this->dateDisponibilite = $dateDisponibilite;
        $this->compte = $compte;
    }

    public function getCompte():Compte
    {
        return $this->compte;
    }

    public function setCompte(Compte $compte): void
    {
        $this->compte = $compte;
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
