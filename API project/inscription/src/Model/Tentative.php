<?php

namespace App\Model;

use DateTime;

class Tentative
{
    private int $nombre;
    private DateTime $dateDisponibilite;

    public function __construct(int $nombre=0, \DateTime $dateDisponibilite=new DateTime())
    {
        $this->nombre = $nombre;
        $this->dateDisponibilite = $dateDisponibilite;
    }

    public function getNombre(): int
    {
        return $this->nombre;
    }

    public function setNombre(int $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function getDateDisponibilite(): DateTime
    {
        return $this->dateDisponibilite;
    }

    public function setDateDisponibilite(DateTime $dateDisponibilite): void
    {
        $this->dateDisponibilite = $dateDisponibilite;
    }
}
