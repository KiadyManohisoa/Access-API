<?php

namespace App\Model;

class NoteMatiere
{
    public string $uE;
    public string $intitule;
    public int $credits;
    public float $note;
    public \DateTime $session;

    public function __construct(string $uE, string $intitule, int $credits, float $note, \DateTime $session)
    {
        $this->uE = $uE;
        $this->intitule = $intitule;
        $this->credits = $credits;
        $this->note = $note;
        $this->session = $session;
    }

    public function getUE(): string
    {
        return $this->uE;
    }

    public function setUE(string $uE): self
    {
        $this->uE = $uE;
        return $this;
    }

    public function getIntitule(): string
    {
        return $this->intitule;
    }

    public function setIntitule(string $intitule): self
    {
        $this->intitule = $intitule;
        return $this;
    }

    public function getCredits(): int
    {
        return $this->credits;
    }

    public function setCredits(int $credits): self
    {
        $this->credits = $credits;
        return $this;
    }

    public function getNote(): float
    {
        return $this->note;
    }

    public function setNote(float $note): self
    {
        $this->note = $note;
        return $this;
    }

    public function getSession(): \DateTime
    {
        return $this->session;
    }

    public function setSession(\DateTime $session): self
    {
        $this->session = $session;
        return $this;
    }
}
