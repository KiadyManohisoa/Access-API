<?php

namespace App\Model;

class ResultatSemestre 
{
    public array $noteMatieres;

    public function __construct(array $noteMatieres = [])
    {
        $this->noteMatieres = $noteMatieres;
    }

    public function getNoteMatieres(): array
    {
        return $this->noteMatieres;
    }

    public function addNoteMatiere(NoteMatiere $noteMatiere): self
    {
        $this->noteMatieres[] = $noteMatiere;
        return $this;
    }

    public function setNoteMatieres(array $noteMatieres): self
    {
        $this->noteMatieres = $noteMatieres;
        return $this;
    }
}
