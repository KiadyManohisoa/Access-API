<?php

namespace App\Entity;

use App\Repository\TentativeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TentativeRepository::class)]
class Tentative
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_tentative = null;

    #[ORM\ManyToOne(inversedBy: 'tentatives')]
    private ?Compte $Compte = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateTentative(): ?\DateTimeInterface
    {
        return $this->date_tentative;
    }

    public function setDateTentative(\DateTimeInterface $date_tentative): static
    {
        $this->date_tentative = $date_tentative;

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
