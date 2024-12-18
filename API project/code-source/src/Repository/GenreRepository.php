<?php

namespace App\Repository;

use App\Entity\Genre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

class GenreRepository extends ServiceEntityRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Genre::class);
        $this->entityManager = $entityManager;
    }

    public function create(Genre $genre): Genre
    {
        // Persister l'entité genre et l'enregistrer dans la base de données
        $this->entityManager->persist($genre);
        $this->entityManager->flush();

        return $genre; // Retourner l'entité genre persistée
    }
   
}
