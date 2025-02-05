<?php

    namespace App\Model;
    use Doctrine\DBAL\Connection;
    use DateTime;

    class HistoriqueUtilisateur {


        public string $id ; 
        public Utilisateur $utilisateur ; 
        public DateTime $dateChangement ; 
        public string $action ;


        //Getter and setter 

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

        public function getDateChangement(): DateTime
        {
            return $this->dateChangement;
        }

        public function setDateChangement(DateTime $dateChangement): void
        {
            $this->dateChangement = $dateChangement;
        }

        public function getaAction(): string
        {
            return $this->action;
        }

        public function setAction(String $action): void
        {
            $this->action = $action;
        }

       
        // Constructeur
        public function __construct( string $id="", ?Utilisateur $utilisateur, ?DateTime $dateChangement ,string $action) {
            
            $this->setId($id);
            $this->setUtilisateur($utilisateur) ;
            $this->setAction($action) ; 
            $this->setDateChangement($dateChangement);
        }


    // CRUD 

    public static function getByDateChangement(Connection $connection, DateTime $dateChagement): ?array
    {
        $query = 'SELECT * FROM historiqueUtilisateur where dateexecution >= ?';
        $stmt = $connection->executeQuery($query, [$dateChagement->format('Y-m-d')]);

        $rows = $stmt->fetchAllAssociative();
        $historiques = [];

        foreach ($rows as $row) {
            $historiques[] = new HistoriqueUtilisateur($row['id'], Utilisateur::getById($connection, $row['idutilisateur']),new DateTime($row['dateexecution']), $row['operation']);

        }

        return $historiques;
    }

}

?>