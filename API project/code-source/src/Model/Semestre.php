<?php

namespace App\Model;

class Semestre
{
    public string $id;
    public string $nom;

    public function __construct(string $id='', string $nom='')
    {
        $this->id = $id;
        $this->nom = $nom;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }
}
