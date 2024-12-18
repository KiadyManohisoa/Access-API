<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
#[ORM\Entity]
class Utilisateur
{
    #[ORM\Id]
    #[ORM\Column(type: "string", length: 14)]
    private $id;

    #[ORM\Column(type: "string", length: 50, unique: true)]
    private $mail;

    #[ORM\Column(type: "string", length: 200)]
    private $mdp;


    #[ORM\Column(type: "string", length: 255)]
    private $salt;


    #[ORM\Column(type: "string", length: 100)]
    private $nom;


    #[ORM\Column(type: "string", length: 30, nullable: true)]
    private $prenom;


    #[ORM\Column(type: "date")]
    private $date_naissance;

    private Tentative $tentative;

    public function getTentative(): Tentative
    {
        return $this->tentative;
    }

    public function setTentative(Tentative $tentative): void
    {
        $this->tentative = $tentative;
    }


    #[ORM\Column(type: "string", length: 14)]
    private ?string $idgenre;

    //variables a part

    private Genre $genre;

    public function getGenre(): Genre
    {
        return $this->genre;
    }

    public function setGenre(Genre $genre): void
    {
        $this->genre = $genre;
    }


    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): self
    {
        $this->mdp = $mdp;

        return $this;
    }

    public function getSalt(): ?string
    {
        return $this->salt;
    }

    public function setSalt(string $salt): self
    {
        $this->salt = $salt;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->date_naissance;
    }

    public function setDateNaissance(\DateTimeInterface $date_naissance): self
    {
        $this->date_naissance = $date_naissance;

        return $this;
    }

    public function getIdGenre(): ?string
    {
        return $this->idgenre;
    }

    public function setIdGenre(string $idgenre): self
    {
        $this->idgenre = $idgenre;

        return $this;
    }

}
