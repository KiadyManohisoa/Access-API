<?php

namespace App\Entity;

use App\Repository\CompteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

/**
 * L'entité utilise les attributs PHP 8 au lieu des annotations.
 */
#[ORM\Entity(repositoryClass: CompteRepository::class)]
#[ORM\Table(name: 'compte')]
class Compte
{
    #[ORM\Id]
    #[ORM\Column(type: "string", length: 14, unique: true)]
    private ?string $id = null;

    #[ORM\Column(type: Types::SMALLINT, options: ['default' => 0])]
    private ?int $d_nb_tentative = 0;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dDateDebloquage = null;

    #[ORM\Column(type: 'string', length: 6, nullable: true)]
    private ?string $dPinActuel = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dDateExpirationPin = null;

    #[ORM\ManyToOne(targetEntity: 'App\Entity\Utilisateur')]
    #[ORM\JoinColumn(name: 'id_utilisateur', referencedColumnName: 'id', nullable: false)]
    private ?Utilisateur $utilisateur = null;

    /**
     * @var Collection<int, Tentative>
     */
    #[ORM\OneToMany(targetEntity: Tentative::class, mappedBy: 'Compte')]
    private Collection $tentatives;

    /**
     * @var Collection<int, TokenCompte>
     */
    #[ORM\OneToMany(targetEntity: TokenCompte::class, mappedBy: 'Compte')]
    private Collection $tokenComptes;

    /**
     * @var Collection<int, PIN>
     */
    #[ORM\OneToMany(targetEntity: PIN::class, mappedBy: 'Compte')]
    private Collection $pINs;

    public function __construct()
    {
        $this->tentatives = new ArrayCollection();
        $this->tokenComptes = new ArrayCollection();
        $this->pINs = new ArrayCollection();
    }

    // Getters et setters
    public function getId(): ?string
    {
        return $this->id;
    }

    public function getDNbTentative(): ?int
    {
        return $this->d_nb_tentative;
    }

    public function setDNbTentative(int $d_nb_tentative): static
    {
        $this->d_nb_tentative = $d_nb_tentative;

        return $this;
    }

    public function getDDateDebloquage(): ?\DateTimeInterface
    {
        return $this->dDateDebloquage;
    }

    public function setDDateDebloquage(\DateTimeInterface $dDateDebloquage): static
    {
        $this->dDateDebloquage = $dDateDebloquage;

        return $this;
    }

    public function getDPinActuel(): ?string
    {
        return $this->dPinActuel;
    }

    public function setDPinActuel(string $dPinActuel): static
    {
        $this->dPinActuel = $dPinActuel;

        return $this;
    }

    public function getDDateExpirationPin(): ?\DateTimeInterface
    {
        return $this->dDateExpirationPin;
    }

    public function setDDateExpirationPin(\DateTimeInterface $dDateExpirationPin): static
    {
        $this->dDateExpirationPin = $dDateExpirationPin;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * @return Collection<int, Tentative>
     */
    public function getTentatives(): Collection
    {
        return $this->tentatives;
    }

    public function addTentative(Tentative $tentative): static
    {
        if (!$this->tentatives->contains($tentative)) {
            $this->tentatives->add($tentative);
            $tentative->setCompte($this);
        }

        return $this;
    }

    public function removeTentative(Tentative $tentative): static
    {
        if ($this->tentatives->removeElement($tentative)) {
            // set the owning side to null (unless already changed)
            if ($tentative->getCompte() === $this) {
                $tentative->setCompte(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TokenCompte>
     */
    public function getTokenComptes(): Collection
    {
        return $this->tokenComptes;
    }

    public function addTokenCompte(TokenCompte $tokenCompte): static
    {
        if (!$this->tokenComptes->contains($tokenCompte)) {
            $this->tokenComptes->add($tokenCompte);
            $tokenCompte->setCompte($this);
        }

        return $this;
    }

    public function removeTokenCompte(TokenCompte $tokenCompte): static
    {
        if ($this->tokenComptes->removeElement($tokenCompte)) {
            // set the owning side to null (unless already changed)
            if ($tokenCompte->getCompte() === $this) {
                $tokenCompte->setCompte(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PIN>
     */
    public function getPINs(): Collection
    {
        return $this->pINs;
    }

    public function addPIN(PIN $pIN): static
    {
        if (!$this->pINs->contains($pIN)) {
            $this->pINs->add($pIN);
            $pIN->setCompte($this);
        }

        return $this;
    }

    public function removePIN(PIN $pIN): static
    {
        if ($this->pINs->removeElement($pIN)) {
            // set the owning side to null (unless already changed)
            if ($pIN->getCompte() === $this) {
                $pIN->setCompte(null);
            }
        }

        return $this;
    }
}
