<?php

namespace App\Controller;

use App\Model\ConnectionUtilisateur;
use App\Service\ReponseJSON;
use App\Service\UtilDB;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\DBAL\Connection;
use App\Model\Utilisateur;
use App\Model\Compte;
use App\Service\ServiceMail;

class AuthentificationController extends AbstractController
{

    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    #[Route("/api/auth/login", methods: ["POST"])]
    public function connectionUtilisateur (Request $request, ServiceMail $serviceMail): JsonResponse
    {
        $reponseJson = new ReponseJSON();
        $status = '';
        $code = null;
        $error = '';

        $data = json_decode($request->getContent(), true);
        $mailUtilisateur = $data['mail'];
        $motDePasse = $data['motdepasse'];
        $utilisateur = new Utilisateur(mail:$mailUtilisateur, mdp:$motDePasse);
        $connectionUtilisateur = new ConnectionUtilisateur();
        $datas = null;
        try {
            $connectionUtilisateur->processus_connection($this->connection, $utilisateur, $serviceMail);            
            $datas = array('message' => 'Vérifiez votre boîte mail car le code secret vous a été transféré');
            $status = 'success';
            $code = 200;
        }
        catch(\Exception $e) {
            $status = 'error';
            $code = 500;
            $error = $e->getMessage();
        }
        return $reponseJson->render($status, $code, $error,$datas);
    } 
    



}
