<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class TokenCompte
{
    #[ORM\Id]
    #[ORM\Column(type: 'string')]
    private ?string $id;

    #[ORM\Column(type: 'date')]
    private $date_expiration;

    #[ORM\Column(type: 'string')]
    private ?string $valeur;

    #[ORM\Column(type: 'string')]
    private ?string $idCompte;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    public function getDateExpiration(): ?string
    {
        return $this->date_expiration;
    }

    public function setDateExpiration(?string $date_expiration): void
    {
        $this->date_expiration = $date_expiration;
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
}
