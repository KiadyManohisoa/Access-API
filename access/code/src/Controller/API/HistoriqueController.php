<?php
    
    // src/Controller/GenreController.php
    namespace App\Controller\API;

use App\Model\HistoriqueUtilisateur;
    use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\JsonResponse;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;

    use Doctrine\DBAL\Connection;

    class HistoriqueController extends AbstractController {

        private Connection $connection ;

        public function __construct(Connection $connection)
        {
            $this->connection = $connection;
        }

        #[Route('/historiques/{dateChangement}', methods : 'GET')]

        public function getHistoriques(DateTime $dateChangement): JsonResponse
        {
            $historiques = HistoriqueUtilisateur::getByDateChangement($this->connection, $dateChangement);
            return new JsonResponse( $historiques);

        }


    }

?>