<?php

namespace App\Model;

use DateTime;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use App\Exception\Mail\MailIntrouvableException;
use App\Exception\Model\CompteException;
use App\Exception\Model\AuthentificationException;
use App\Service\HashageService;
use App\Exception\Model\ModelException;
use App\Exception\Model\ValeurInvalideException;
use HashContext;
use App\Service\ServiceMail;


class Utilisateur
{
    public string $id;
    public string $mail;
    public string $mdp;
    public ?string $salt;
    public string $nom;
    public ?string $prenom;
    public ?\DateTime $dateNaissance;
    public Genre $genre;

    public function se_connecter(Connection $connection): ?Compte {
        $compte = new Compte();
        $firstQuery = "SELECT * FROM v_CompteUtilisateur WHERE mail = ?";

        try {
            $result = $connection->fetchAssociative($firstQuery, [$this->getMail()]);

            if (!$result) {
                throw new MailIntrouvableException(emailInvalide:$this->getMail());
            }

            $id = $result['id'];
            $mdpHash = $result['mdp'];
            $dateDebloquage = $result['d_date_debloquage'] ? new \DateTime($result['d_date_debloquage']) : null;

            // Vérifier le mot de passe
            $serviceHash = new HashageService();
            if (!$serviceHash->verifyPassword($this->getMdp(),$result['salt'], $mdpHash)) {
                throw new AuthentificationException("Le mot de passe est incorrect.");
            }

            // Vérifier si le compte est bloqué
            $dateActuelle = new \DateTime();
            if($dateDebloquage!=null && $dateActuelle <= $dateDebloquage) {
                throw new CompteException("Le compte est temporairement bloqué jusqu'au {$dateDebloquage->format('Y-m-d H:i:s')}.");
            }
            
            // Si tout est valide, instancier l'objet Compte
            $compte->setId($id);
            $compte->setUtilisateur($this);
            $compte->setTentative(new Tentative((int)$result['d_nb_tentative'], $dateDebloquage, $compte));
            $compte->setPin(new Pin($result['d_pin_actuel'], new \DateTime($result['d_date_expiration_pin']), $compte));
        } catch (\Exception $e) {
            throw $e;
        }

        return $compte;
    }

    // public function se_connecter(Connection $connection): ?Compte {
    //     $result = $this->fetchCompteData($connection);

    //     try {        
    //         $this->checkSiCompteExiste($result);
    //         $this->checkMotDePasse($result['mdp'], $result['salt']);
    //         $this->checkSiCompteEstCompteBloque($result['d_date_debloquage']);
    //     }
    //     catch(Exception $e) {
    //         throw $e;
    //     }
        
    //     return $this->creerCompte($result);
    // }
    
    // // Récupère les données du compte utilisateur depuis la base de données
    // private function fetchCompteData(Connection $connection): array {
    //     $query = "SELECT * FROM v_CompteUtilisateur WHERE mail = ?";
    //     return $connection->fetchAssociative($query, [$this->getMail()]);
    // }
    
    // // Vérifie si le compte existe
    // private function checkSiCompteExiste(?array $result): void {
    //     if (!$result) {
    //         throw new MailIntrouvableException(emailInvalide: $this->getMail());
    //     }
    // }
    
    // // Vérifie si le mot de passe est valide
    // private function checkMotDePasse(string $mdpHash, string $salt): void {
    //     $serviceHash = new HashageService();
    //     if (!$serviceHash->verifyPassword($this->getMdp(), $salt, $mdpHash)) {
    //         throw new AuthentificationException("Le mot de passe est incorrect.");
    //     }
    // }
    
    // Vérifie si le compte est temporairement bloqué
    // private function checkSiCompteEstCompteBloque(?string $dateDebloquage): void {
    //     if ($dateDebloquage) {
    //         $dateDebloquage = new \DateTime($dateDebloquage);
    //         $currentDate = new \DateTime();
    //         if ($currentDate <= $dateDebloquage) {
    //             throw new CompteException("Le compte est temporairement bloqué jusqu'au {$dateDebloquage->format('Y-m-d H:i:s')}.");
    //         }
    //     }
    // }
    
    // // Crée et retourne une instance de Compte
    // private function creerCompte(array $result): Compte {
    //     $compte = new Compte();
    //     $compte->setId($result['id']);
    //     $compte->setUtilisateur($this);
    //     $compte->setTentative(new Tentative((int)$result['d_nb_tentative'], 
    //         $result['d_date_debloquage'] ? new \DateTime($result['d_date_debloquage']) : null));
    //     $compte->setPin(new Pin($result['d_pin_actuel'], new \DateTime($result['d_date_expiration_pin'])));
    //     return $compte;
    // }
    

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

    public function getSalt(): ?string
    {
        return $this->salt;
    }

    public function setSalt(?string $salt): void
    {
        $this->salt = $salt;
    }

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

    public function update(Connection $connection): void
    {
        $query = "UPDATE Utilisateur SET mail = ?, mdp = ?, nom = ?, prenom = ?, date_naissance = ?, idGenre = ?, salt = ? WHERE id = ?";

        $connection->executeStatement($query, [
            $this->getMail(),
            $this->getMdp(),
            $this->getNom(),
            $this->getPrenom(),
            $this->getDateNaissance() ? $this->getDateNaissance()->format('Y-m-d') : null,
            $this->getGenre() ? $this->getGenre()->getId() : null,
            $this->getSalt(),
            $this->getId()
        ]);
    }

    // Inscription 

    public function s_inscrire(Connection $connection, HashageService $util, ServiceMail $serviceMail):void{

        try{
            $serviceMail->estValide($this->getMail());          // Si pas throws donc email valide

            // Code de hashage
            $sel = $util->getRandomSalt();
            $hash = $util->getHashPassword($this->getMdp(), $sel);
            $this->setMdp($hash);
            $this->setSalt($sel);

            $this->insert($connection);                 // Enregistrement de l'utilisateur

            $serviceMail->envoyerMail($this->getMail(), ['id'=>$this->getId()], "emails/confirmation.html.twig", "Confirmation d'identité");

        } catch(\Exception $e){
            throw $e;
        }
       
    }

    public function confirmerInscription(Connection $connection) :void{

        try{
           
            $inscription = new Compte(utilisateur:$this);
            $inscription->insert($connection);
        } catch(\Exception $e){
            throw $e;
        }
       
    }

    public static function construireObject(array $tab):Utilisateur {

        $utilisateur = new Utilisateur();
        if (!isset($tab['mail'], $tab['mdp'], $tab['nom'], $tab['date_naissance'], $tab['genre'])) {
            throw new ModelException('Données manquantes', $utilisateur);
        }

        try {
            $dateNaissance = new \DateTime($tab['date_naissance']);
        } catch (\Exception $e) {
            throw new ValeurInvalideException('Date de naissance invalide', $dateNaissance);
        }

        $utilisateur = new Utilisateur(
            id: '', // ID généré par la BDD
            mail: $tab['mail'],
            mdp: $tab['mdp'],
            nom: $tab['nom'],
            prenom: $tab['prenom'] ?? null,
            dateNaissance: $dateNaissance,
            genre: $tab['genre']
        );

        return $utilisateur ;

    }
}