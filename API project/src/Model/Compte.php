<?php

namespace App\Model;

use App\Config\AppConfig;
use App\Model\Utilisateur;
use App\Model\Tentative;
use App\Model\Pin;
use Doctrine\DBAL\Connection;
use DateTime;
use DateInterval;
use App\Exception\Model\ModelException;

class Compte
{
    public string $id;
    public Utilisateur $utilisateur;
    public Tentative $tentative;
    public Pin $pin;

    public function update(Connection $connection): void
    {
        $data = [
            'd_nb_tentative' => $this->getTentative()->getNombre(),
            'd_date_debloquage' => $this->getTentative()->getDateDisponibilite() ? $this->getTentative()->getDateDisponibilite()->format('Y-m-d H:i:s') : null,
            'd_pin_actuel' => $this->getPin()->getPin(),
            'd_date_expiration_pin' => $this->getPin()->getDateExpiration() ? $this->getPin()->getDateExpiration()->format('Y-m-d H:i:s') : null,
            'id_utilisateur' => $this->getUtilisateur()->getId()
        ];

        $connection->update(
            'compte',  
            $data,  
            ['id' => $this->getId()]
        );
    }

    public function ajouterTentativeEchouer(Connection $connection) : void {
        $this->getTentative()->insert($connection);
        $this->getTentative()->setNombre($this->getTentative()->getNombre()+1);
        $this->update($connection);
    }

    public function getProchainDateDeDebloquage(): DateTime
    {
        $currentDateTime = new DateTime();

        list($hours, $minutes, $seconds) = explode(':', AppConfig::DUREE_BLOQUAGE_COMPTE);

        $interval = new DateInterval('PT' . $hours . 'H' . $minutes . 'M' . $seconds . 'S');
        
        $prochainDebloquage = clone $currentDateTime;
        $prochainDebloquage->add($interval);

        return $prochainDebloquage;
    }
    
    public function bloquer(Connection $connection): void
    {
        $compteId = $this->id;
        $this->getTentative()->setNombre($this->getTentative()->getNombre() + 1);

        $connection->update(
            'compte', // Nom de la table
            [
                'd_nb_tentative' => $this->getTentative()->getNombre() ,  
                'd_date_debloquage' => $this->getProchainDateDeDebloquage()  
            ],
            [
                'id' => $this->getId()
            ]
        );
    }

    public function __construct(string $id='', Utilisateur $utilisateur= new Utilisateur(), Tentative $tentative=new Tentative(), Pin $pin=new Pin())
    {
        $this->id = $id;
        $this->utilisateur = $utilisateur;
        $this->tentative = $tentative;
        $this->pin = $pin;
    }

    public function getCompteByMail(Connection $connection): ?Compte
    {
        $compte = new Compte();
        $firstQuery = "SELECT * FROM v_CompteUtilisateur WHERE mail = ?";
        try {
            $result = $connection->fetchAssociative($firstQuery, [$this->getUtilisateur()->getMail()]);
            $compte->setId($result['id']);
            $compte->setUtilisateur(new Utilisateur(mail:$result['mail'], mdp:$result['mdp']));
            $compte->setTentative(new Tentative((int)$result['d_nb_tentative'], new \DateTime($result['d_date_debloquage'])));
            $compte->setPin(new Pin($result['d_pin_actuel'], new \DateTime($result['d_date_expiration_pin'])));
        } catch (\Exception $e) {
            throw $e;
        }

        return $compte;

    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getUtilisateur(): Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(Utilisateur $utilisateur): void
    {
        $this->utilisateur = $utilisateur;
    }

    public function getTentative(): Tentative
    {
        return $this->tentative;
    }

    public function setTentative(Tentative $tentative): void
    {
        $this->tentative = $tentative;
    }

    public function getPin(): Pin
    {
        return $this->pin;
    }

    public function setPin(Pin $pin): void
    {
        $this->pin = $pin;
    }

    public static function getByIdUtilisateur(Connection $connection, string $idUtilisateur): ?Compte
    {
        $query = 'SELECT * FROM Compte WHERE id_Utilisateur = ?';
        $stmt = $connection->executeQuery($query, [$idUtilisateur]);
        $row = $stmt->fetchAssociative();

        if ($row) {
            $utilisateur = Utilisateur::getById($connection, $row['id_utilisateur']);
            return new Compte($row['id'], $utilisateur);

        }
        return null;
    }

    public function insert(Connection $connection): void {

        if($this->getUtilisateur()==null) {

            throw new ModelException("Données du compte est invalide", $this);
        }
        $query = "INSERT INTO Compte (d_date_debloquage, d_date_expiration_pin,id_utilisateur) VALUES (?, ?, ?) RETURNING id";
        $stmt = $connection->executeQuery($query, [
            null,
            null,
            $this->getUtilisateur()->getId()
        ]);
        $id = $stmt->fetchOne();
        $this->setId($id);

        // d_nb_tentative, d_date_debloquage, d_pin_actuel, d_date_expiration_pin, id_utilisateur
    }
}
