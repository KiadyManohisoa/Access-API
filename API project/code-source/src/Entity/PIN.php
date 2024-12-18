<?php

namespace App\Entity;

use App\Repository\PINRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PINRepository::class)]
class PIN
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 6)]
    private ?string $pin = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_expiration = null;

    #[ORM\ManyToOne(inversedBy: 'pINs')]
    private ?Compte $Compte = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPin(): ?string
    {
        return $this->pin;
    }

    public function setPin(string $pin): static
    {
        $this->pin = $pin;

        return $this;
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
