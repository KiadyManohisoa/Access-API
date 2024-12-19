<?php

    namespace App\Model;

    use Doctrine\DBAL\Connection;

    use App\Exception\Model\ModelException;
    use App\Exception\Model\ValeurInvalideException;

    class Compte
    {
        private ?string $id;
        private Utilisateur $utilisateur;
        private ?Tentative $tentative;
        private ?Pin $pin;

        public function __construct(string $id='', Utilisateur $utilisateur= null, Tentative $tentative=null, Pin $pin=null)
        {
            $this->id = $id;
            $this->utilisateur = $utilisateur;
            $this->tentative = $tentative;
            $this->pin = $pin;
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


        // CRUD : 
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

?>