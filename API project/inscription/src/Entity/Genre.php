<?php

    namespace App\Entity;

    use Doctrine\ORM\Mapping as ORM;
    use App\Repository\GenreRepository;
    use Symfony\Component\Serializer\Annotation\Groups;

    #[ORM\Table(name: "Genre")]
    #[ORM\Entity(repositoryClass: GenreRepository::class)]
    class Genre
    {
        #[ORM\Id]
        #[ORM\Column(type: "string", length: 14, unique: true)]
        // #[ORM\GeneratedValue(strategy: "CUSTOM")]
        // #[ORM\CustomIdGenerator(class: "App\Utils\CustomIdGenerator")]
        public ?string $id = null;

        #[ORM\Column(type: "string", length: 50, unique: true)]
        public string $libelle;

        // Getters et setters
        public function getId(): ?string
        {
            return $this->id;
        }

        public function getLibelle(): string
        {
            return $this->libelle;
        }

        public function setLibelle(string $libelle): self
        {
            $this->libelle = $libelle;
            return $this;
        }
    }
?>