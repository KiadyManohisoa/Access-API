<?php
    
    // src/Controller/GenreController.php
    namespace App\Controller\Test;

    use App\Model\Utilisateur;
use App\Service\ReponseJSON;
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
        private ReponseJSON $response; 


        public function __construct(Utilisateur $utilisateur, Connection $connection, ReponseJSON $response)
        {
            $this->utilisateur = $utilisateur;
            $this->connection = $connection;
            $this->response = $response;
        }

        #[Route('/api/utilisateurs', methods : 'GET')]
        public function liste(): JsonResponse
        {
            return new JsonResponse($this->utilisateur->getAll($this->connection));
        }

        #[Route('/api/utilisateur', methods : 'POST')]

        public function inscription(Request $request, Util $util, ServiceMail $serviceMail): JsonResponse
        {
            // Récupérer les données du corps de la requête
            $data = json_decode($request->getContent(), true);
            try {
                
                $utilisateur = $this->utilisateur->construireObject($data);
                $utilisateur->s_inscrire($this->connection, $util, $serviceMail);
                return $this->response->rendre('Inscription réussie', 200, null, ['utilisateur'=>$utilisateur]);
                

            } catch(Exception $e){
                return $this->response->rendre('Inscription échouée', 400,  'Erreur lors de l\'insertion : ' . $e->getMessage(), null);
            }
        }


        #[Route('/api/utilisateur/{id}/confirmation', methods : 'GET', name:'utilisateur_confirmation')]
        public function confirmation(string $id): JsonResponse {
            try {

                $utilisateur = $this->utilisateur->getById($this->connection, $id);
                $utilisateur->confirmerInscription($this->connection);
                return $this->response->rendre('Confirmation réussi', 200, null, []);


            } catch(Exception $e){
                return $this->response->rendre('Confirmation échouée', 400,  'Erreur lors de la confirmation : ' . $e->getMessage(), null);
            }

        }


    
    }   

?>