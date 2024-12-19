<?php

namespace App\Model;

use App\Model\Utilisateur;
use App\Model\Tentative;
use App\Model\Pin;

class Compte
{
    private string $id;
    // private Utilisateur $utilisateur;
    private Tentative $tentative;
    private Pin $pin;

    public function __construct(string $id='', Utilisateur $utilisateur= null, Tentative $tentative=null, Pin $pin=null)
    {
        $this->id = $id;
        // $this->utilisateur = $utilisateur;
        $this->tentative = $tentative;
        $this->pin = $pin;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    // public function getUtilisateur(): Utilisateur
    // {
    //     return $this->utilisateur;
    // }

    // public function setUtilisateur(Utilisateur $utilisateur): void
    // {
    //     $this->utilisateur = $utilisateur;
    // }

    public function getTentative(): Tentative
    {
        return $this->tentative;
    }

    public function setTentative(Tentative $tentative): void
    {
        $this->tentative = $tentative;
    }

    public function getPin(): Pin
    {
        return $this->pin;
    }

    public function setPin(Pin $pin): void
    {
        $this->pin = $pin;
    }
}
