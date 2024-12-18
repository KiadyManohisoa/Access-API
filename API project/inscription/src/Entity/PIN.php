<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class PIN
{
    #[ORM\Id]
    #[ORM\Column(type: 'string')]
    private ?string $id;


    #[ORM\Column(type: 'string')]
    private ?string $pin;

    #[ORM\Column(type: 'date')]
    private $date_expiration;

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

    public function getPin(): ?string
    {
        return $this->pin;
    }

    public function setPin(?string $pin): void
    {
        $this->pin = $pin;
    }

    public function getDateExpiration(): ?string
    {
        return $this->date_expiration;
    }

    public function setDateExpiration($date_expiration): void
    {
        $this->date_expiration = $date_expiration;
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
