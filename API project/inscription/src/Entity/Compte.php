<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Compte
{
    #[ORM\Id]
    #[ORM\Column(type: 'string')]
    private ?string $id;

    #[ORM\Column(type: 'integer')]
    private ?int $d_nb_tentative = 0;


    #[ORM\Column(type: 'datetime' , nullable : true)]
    private ?\DateTimeInterface $d_date_debloquage;


    #[ORM\Column(type: 'string')]
    private ?string $d_pin_actuel;


    #[ORM\Column(type: 'datetime'  , nullable : true)]
    private ?DateTimeInterface $d_date_expiration_pin;


    #[ORM\Column(type: 'string' ,nullable : false)]
    private ?string $idUtilisateur;


    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getDNbTentative(): ?int
    {
        return $this->d_nb_tentative;
    }

    public function setDNbTentative(int $d_nb_tentative): self
    {
        $this->d_nb_tentative = $d_nb_tentative;
        return $this;
    }

    public function getDDateDebloquage(): ?string
    {
        return $this->d_date_debloquage->format('Y-m-d H:i:s');
    }

    public function setDDateDebloquage(?\DateTimeInterface $d_date_debloquage): self
    {
        $this->d_date_debloquage = $d_date_debloquage;
        return $this;
    }

    public function getDPinActuel(): ?string
    {
        return $this->d_pin_actuel;
    }

    public function setDPinActuel(?string $d_pin_actuel): self
    {
        $this->d_pin_actuel = $d_pin_actuel;
        return $this;
    }

    public function getDDateExpirationPin(): ?string
    {
        return $this->d_date_expiration_pin->format('Y-m-d H:i:s');
    }

    public function setDDateExpirationPin(?DateTimeInterface $d_date_expiration_pin): self
    {
        $this->d_date_expiration_pin = $d_date_expiration_pin;
        return $this;
    }

    public function getIdUtilisateur(): ?string
    {
        return $this->idUtilisateur;
    }

    public function setIdUtilisateur(?string $idUtilisateur): self
    {
        $this->idUtilisateur = $idUtilisateur;
        return $this;
    }
}
