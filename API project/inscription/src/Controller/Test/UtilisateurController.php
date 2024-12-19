<?php
    
    // src/Controller/GenreController.php
    namespace App\Controller\Test;

    use App\Model\Utilisateur;
    use App\Util\Util;
    use App\Service\ServiceMail;

    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\JsonResponse;
    use Symfony\Component\Routing\Annotation\Route;
    use Doctrine\DBAL\Connection;
    use Exception;

    class UtilisateurController extends AbstractController
    {
        private $utilisateur;
        private Connection $connection ;


        public function __construct(Utilisateur $utilisateur, Connection $connection)
        {
            $this->utilisateur = $utilisateur;
            $this->connection = $connection;
        }

        #[Route('/utilisateurs', methods : 'GET')]
        public function liste(Request $request): JsonResponse
        {
            return new JsonResponse($this->utilisateur->getAll($this->connection));
        }

        #[Route('/utilisateur', methods : 'POST')]

        public function inscription(Request $request, Util $util, ServiceMail $serviceMail): JsonResponse
        {
            // Récupérer les données du corps de la requête
            $data = json_decode($request->getContent(), true);
            try {
                
                $utilisateur = $this->utilisateur->construireObject($data);
                $utilisateur->s_inscrire($this->connection, $util, $serviceMail);
               
                return new JsonResponse([
                    'id' => $utilisateur->getId(),
                    'mail' => $utilisateur->getMail(),
                    'nom' => $utilisateur->getNom(),
                    'prenom' => $utilisateur->getPrenom(),
                    'date_naissance' => $utilisateur->getDateNaissance()->format('Y-m-d'),
                    'genre' => $utilisateur->getGenre()
                ], 201);

            } catch(Exception $e){
                return new JsonResponse(['error' => 'Erreur lors de l\'insertion : ' . $e->getMessage()], 500);
            }
        }

    }

?>