<?php

namespace App\Controller;

use App\Entity\Compte;
use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepo;
use App\Repository\CompteRepo;
use App\Service\HashageService;
use Doctrine\DBAL\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ControllerAPI extends AbstractController
{
    private $utilisateurRepository;
    private $compteRepo;


    public function __construct(UtilisateurRepo $utilisateurRepository, CompteRepo $compteRepo)
    {
        $this->utilisateurRepository = $utilisateurRepository;
        $this->compteRepo = $compteRepo;
    }

    #[Route('/access-api/utilisateur/create', name: 'utilisateur_create', methods: ['POST'] )]
    public function createUtlisateur(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $email = $data['mail'] ?? '';
        $mdp = $data['mdp'] ?? '';

        $hashService = new HashageService();

        $salt = $hashService->getRandomSalt();
        $hashpassword = $hashService->getHashPassword($mdp, $salt);

        $nom = $data['nom'] ?? '';
        $prenom = $data['prenom'] ?? '';
        $dateNaissance = new \DateTime($data['datenaissance']);
        $idGenre = $data['idgenre'] ?? '';

        $user = new Utilisateur();
        $user->setMail($email);
        $user->setMdp($hashpassword);
        $user->setIdGenre($idGenre);
        $user->setNom($nom);
        $user->setPrenom($prenom);
        $user->setDateNaissance($dateNaissance);
        $user->setSalt($salt);

        try {
            // Insérer l'utilisateur
            try {
                $user = $this->utilisateurRepository->insertWithDefaultValues($user);
            } catch (Exception $e) {
                throw $e;
            }
            return new JsonResponse([
                'message' => 'Utilisateur et compte créés avec succès.'
            ], 201);
        } catch (\InvalidArgumentException $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Erreur inattendue : ' . $e->getMessage()], 500);
        }
    }

    #[Route('/access-api/compte/create', name: 'compte_create', methods: ['POST'] )]
    public function createCompte(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $idUtilisateur = $data['idutilisateur'] ?? null;
        if (!$idUtilisateur) {
            return new JsonResponse(['error' => 'L\'ID utilisateur est requis.'], 400);
        }

        $now = new \DateTime();

        $compte = new Compte();
        $compte->setDDateDebloquage($now);
        $compte->setIdUtilisateur($idUtilisateur);

        try {
            $this->compteRepo->create($compte);

            return new JsonResponse([
                'message' => 'Compte créé avec succès.'
            ], 201);
        } catch (\Exception $e) {
            return new JsonResponse([
                'error' => 'Erreur lors de la création du compte : ' . $e->getMessage()
            ], 500);
        }
    }

}