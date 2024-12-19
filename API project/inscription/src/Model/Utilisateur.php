<?php

namespace App\Model;

use DateTime;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

class Utilisateur
{
    public string $id;
    public string $mail;
    public string $mdp;
    public string $nom;
    public ?string $prenom;
    public ?\DateTime $dateNaissance;
    public Genre $genre;

    // Constructeur
    public function __construct( string $id="", string $mail="", string $mdp="", string $nom="", ?string $prenom="", \DateTime $dateNaissance=null,string $genre="") {
        $this->setId($id);
        $this->setMail($mail);
        $this->setMdp($mdp);
        $this->setNom($nom);
        $this->setPrenom($prenom);
        $this->setDateNaissance($dateNaissance);
        $this->setGenre(new Genre($genre));
    }

    // Getters et Setters

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getMail(): string
    {
        return $this->mail;
    }

    public function setMail(string $mail): void
    {
        $this->mail = $mail;
    }

    public function getMdp(): string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): void
    {
        $this->mdp = $mdp;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): void
    {
        $this->prenom = $prenom;
    }

    public function getDateNaissance(): \DateTime
    {
        return $this->dateNaissance;
        
    }

    public function setDateNaissance(?\DateTime $dateNaissance): void
    {
        $this->dateNaissance = $dateNaissance;
    }

    public function getgenre(): Genre
    {
        return $this->genre;
    }

    public function setGenre(Genre $genre): void
    {
        $this->genre = $genre;
    }

    public function setGenreConnection(Connection $connection, $idGenre) : void {

        $this->setGenre(Genre::getById($connection, $idGenre));

    }


    // CRUD 

    public static function getAll(Connection $connection): array
    {
        $query = 'SELECT * FROM Utilisateur';
        $stmt = $connection->executeQuery($query);
        $results = $stmt->fetchAllAssociative();

        $genres = [];
        foreach ($results as $row) {
            $genres[] = new Utilisateur($row['id'], $row['mail'],$row['mdp'],$row['nom'], $row['prenom'],new DateTime($row['date_naissance']),$row['idgenre']);

            //  public function __construct( string $id, string $mail, string $mdp, string $nom, ?string $prenom, \DateTime $dateNaissance,string $genre) {
        }

        return $genres;
    }


    public static function getById(Connection $connection, string $id): ?Utilisateur
    {
        $query = 'SELECT * FROM Genre WHERE id = ?';
        $stmt = $connection->executeQuery($query, [$id]);
        $row = $stmt->fetchAssociative();

        if ($row) {
            return new Utilisateur($row['id'], $row['mail'],$row['mdp'],$row['nom'], $row['prenom'],new DateTime($row['date_naissance']),$row['idgenre']);

        }
        return null;
    }

    public function insert(Connection $connection): void {

        $query = "INSERT INTO Utilisateur (mail, mdp, nom, prenom, date_naissance, idGenre) VALUES (?, ?, ?, ?, ?, ?) RETURNING id";
        $stmt = $connection->executeQuery($query, [
            $this->getMail(),
            $this->getMdp(),
            $this->getNom(),
            $this->getPrenom(),
            $this->getDateNaissance()->format('Y-m-d'),
            $this->getGenre()->getId()
        ]);
        $id = $stmt->fetchOne();
        $this->setId($id);
    }
}
