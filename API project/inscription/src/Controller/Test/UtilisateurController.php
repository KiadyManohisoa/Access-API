<?php
    
    // src/Controller/GenreController.php
    namespace App\Controller\Test;

    use App\Model\Utilisateur;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\JsonResponse;
    use Symfony\Component\Routing\Annotation\Route;

    use Doctrine\DBAL\Connection;


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

        public function insererUtilisateur(Request $request): JsonResponse
        {
            // Récupérer les données du corps de la requête
            $data = json_decode($request->getContent(), true);

            // Validation des données
            if (!isset($data['mail'], $data['mdp'], $data['nom'], $data['date_naissance'], $data['genre'])) {
                return new JsonResponse(['error' => 'Données manquantes'], 400);
            }

            try {
                // Conversion de la date de naissance
                $dateNaissance = new \DateTime($data['date_naissance']);

                // Création de l'objet Utilisateur
                $utilisateur = new Utilisateur(
                    id: '', // L'ID sera généré automatiquement par la base de données
                    mail: $data['mail'],
                    mdp: $data['mdp'],
                    nom: $data['nom'],
                    prenom: $data['prenom'] ?? null,
                    dateNaissance: $dateNaissance,
                    genre: $data['genre']
                );

                // Appel à la méthode d'insertion avec l'objet Utilisateur
                $utilisateur->insert(
                    $this->connection);

                // Retourner une réponse JSON
                return new JsonResponse([
                    'id' => $utilisateur->getId(),
                    'mail' => $utilisateur->getMail(),
                    'nom' => $utilisateur->getNom(),
                    'prenom' => $utilisateur->getPrenom(),
                    'date_naissance' => $utilisateur->getDateNaissance()->format('Y-m-d'),
                    'genre' => $utilisateur->getGenre(),
                ], 201);

            } catch (\Exception $e) {
                return new JsonResponse(['error' => 'Erreur lors de l\'insertion : ' . $e->getMessage()], 500);
            }
        }

    }

?>