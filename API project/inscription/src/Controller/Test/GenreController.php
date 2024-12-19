<?php
    
    // src/Controller/GenreController.php
    namespace App\Controller\Test;

    use App\Repository\GenreRepository;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;

    class GenreController extends AbstractController
    {
        private $genreRepository;

        // Injection du repository dans le constructeur
        public function __construct(GenreRepository $genreRepository)
        {
            $this->genreRepository = $genreRepository;
        }

        #[Route('/genres', methods : 'GET')]

        public function getAllGenres(): JsonResponse
        {
            $genres = $this->genreRepository->getAll();
            return new JsonResponse( $genres);

            }

        #[Route('/genre/{idGenre}', methods : 'GET')]

        public function getGenreById(string $idGenre): JsonResponse
        {
            $genre = $this->genreRepository->getById($idGenre);

            if (!$genre) {
                return new JsonResponse(['error' => 'Genre not found'], Response::HTTP_NOT_FOUND);
            }

            return new JsonResponse( $genre);
        }
    }

?>
