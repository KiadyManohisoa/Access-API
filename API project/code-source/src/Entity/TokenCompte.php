<?php

namespace App\Entity;

use App\Repository\TokenCompteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TokenCompteRepository::class)]
class TokenCompte
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_expiration = null;

    #[ORM\Column(length: 200)]
    private ?string $valeur = null;

    #[ORM\ManyToOne(inversedBy: 'tokenComptes')]
    private ?Compte $Compte = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateExpiration(): ?\DateTimeInterface
    {
        return $this->date_expiration;
    }

    public function setDateExpiration(\DateTimeInterface $date_expiration): static
    {
        $this->date_expiration = $date_expiration;

        return $this;
    }

    public function getValeur(): ?string
    {
        return $this->valeur;
    }

    public function setValeur(string $valeur): static
    {
        $this->valeur = $valeur;

        return $this;
    }

    public function getCompte(): ?Compte
    {
        return $this->Compte;
    }

    public function setCompte(?Compte $Compte): static
    {
        $this->Compte = $Compte;

        return $this;
    }
}
