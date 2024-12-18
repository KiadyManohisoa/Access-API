<?php

namespace App\Service;

use Doctrine\DBAL\Connection;

class NiveauService
{

    public function __construct()
    {
    }

    public function getAll(Connection $connection): ?array
    {
        $sql = 'SELECT * FROM niveau ';

        // Préparer et exécuter la requête
        $stmt = $connection->prepare($sql);
        $results = $stmt->execute();

        // Retourner les données sous forme de tableau associatif
        return $results->fetchAllAssociative() ?: null;
    }

    public function getSemestreByIdNiveau(Connection $connection, string $idNiveau): ?array
    {
        $sql = 'SELECT * FROM semestre where idNiveau= :idNiveau ';

        // Préparer et exécuter la requête
        $stmt = $connection->prepare($sql);
        $stmt->bindValue('idNiveau', $idNiveau);
        $results = $stmt->execute();

        // Retourner les données sous forme de tableau associatif
        return $results->fetchAllAssociative() ?: null;
    }


}

?>
