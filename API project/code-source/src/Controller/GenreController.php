<?php
namespace App\Controller;

use App\Repository\GenreRepository;
use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Util\UtileDAO;
use App\Entity\Genre;

class GenreController extends AbstractController
{
    private Connection $connection;
    private GenreRepository $genreRepository;  // Ajout du type-hint ici

    public function __construct(Connection $connection, GenreRepository $genreRepository)
    {
        $this->connection = $connection;
        $this->genreRepository = $genreRepository;
    }

    #[Route('/creategenre', name: 'create_genre', methods: ['POST'])]
    public function createGenre(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $libelle = $data['libelle'];

        // Générer l'ID en utilisant la méthode UtileDAO
        $idPrefix = "GR";  // Exemple de préfixe
        $table = "genre";   // Nom de la table "genre"
        $generatedId = UtileDAO::construirePK($this->connection, $table, $idPrefix);

        // Créer l'entité Genre
        $genre = new Genre();
        $genre->setLibelle($libelle);
        $genre->setId($generatedId);  // ID généré par la méthode

        // Persister l'entité
        $this->genreRepository->create($genre);

        return $this->json($genre, 201);
    }
}
