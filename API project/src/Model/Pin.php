<?php

namespace App\Model;

use DateTime;

class Pin
{
    public string $pin;
    public DateTime $dateExpiration;
    public Compte $compte;

    public function insert($connection): void
    {
        $data = [
            'pin' => $this->getPin(),
            'date_expiration' => $this->getDateExpiration()->format('Y-m-d H:i:s'),  // Formater la date pour l'insertion
            'idcompte' => $this->getCompte()->id  
        ];
        $connection->insert('pin', $data);
    }

    public function __construct(string $pin='', \DateTime $dateExpiration= new DateTime(), Compte $compte = new Compte())
    {
        $this->pin = $pin;
        $this->dateExpiration = $dateExpiration;
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

    public function getPin(): string
    {
        return $this->pin;
    }

    public function setPin(string $pin): void
    {
        $this->pin = $pin;
    }

    public function getDateExpiration(): DateTime
    {
        return $this->dateExpiration;
    }

    public function setDateExpiration(DateTime $dateExpiration): void
    {
        $this->dateExpiration = $dateExpiration;
    }
}
