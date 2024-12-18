<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
#[ORM\Entity]
class Tentative
{
    #[ORM\id]
    #[ORM\Column(type: 'string')]
    private ?string $id;

    #[ORM\Column(type: 'date')]
    private $date_tentative;

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

    public function getDateTentative(): ?string
    {
        return $this->date_tentative;
    }

    public function setDateTentative(?string $date_tentative): void
    {
        $this->date_tentative = $date_tentative;
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
