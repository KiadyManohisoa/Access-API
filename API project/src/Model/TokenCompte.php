<?php

namespace App\Entity;

use Doctrine\DBAL\Connection;

class TokenCompte
{
    private ?string $id;
    private ?string $valeur;
    private ?string $idCompte;
    private $date_expiration;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    public function getValeur(): ?string
    {
        return $this->valeur;
    }

    public function setValeur(?string $valeur): void
    {
        $this->valeur = $valeur;
    }

    public function getIdCompte(): ?string
    {
        return $this->idCompte;
    }

    public function setIdCompte(?string $idCompte): void
    {
        $this->idCompte = $idCompte;
    }

    public function getDateExpiration(): ?string
    {
        return $this->date_expiration;
    }

    public function setDateExpiration($date_expiration): void
    {
        $this->date_expiration = $date_expiration;
    }

    /**
     * Insère le token dans la base de données
     */
    public function insert(Connection $connection): void
    {
        $sql = 'INSERT INTO tokencompte (id, valeur, date_expiration, idCompte) VALUES (:id, :valeur, :date_expiration, :idCompte)';
        $stmt = $connection->prepare($sql);
        $stmt->bindValue('id', $this->getId());
        $stmt->bindValue('valeur', $this->getValeur());
        $stmt->bindValue('date_expiration', $this->getDateExpiration());
        $stmt->bindValue('idCompte', $this->getIdCompte());
        $stmt->executeStatement();
    }
}
