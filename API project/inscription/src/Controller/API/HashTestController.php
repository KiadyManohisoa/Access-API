<?php

namespace App\Controller\API;

use App\Service\HashageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HashTestController extends AbstractController
{
    private HashageService $hashageService;

    public function __construct(HashageService $hashageService)
    {
        $this->hashageService = $hashageService;
    }

    #[Route('/access-api/hash/generate', name: 'api_generate_hash', methods: ['POST'])]
    public function generateHash(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['password'])) {
            return new JsonResponse(['error' => 'Le champ "password" est requis.'], 400);
        }

        $password = $data['password'];

        $salt = $this->hashageService->getRandomSalt();

        $hash = $this->hashageService->getHashPassword($password, $salt);

        return new JsonResponse([
            'password' => $password,
            'salt' => $salt,
            'hash' => $hash,
        ]);
    }

    #[Route('/access-api/hash/verify', name: 'api_verify_hash', methods: ['POST'])]
    public function verifyHash(Request $request): JsonResponse
    {
        //salt test:B$T/_S?G%hW(;:_G
        //hash test : $2y$10$Ctk9bElE1jx5g2.6JvJwcO6jOyYi4yx5OJ6Vb8yfICyYDoq.EYo4G
        //password test: arijesa123

        $data = json_decode($request->getContent(), true);


        if (!isset($data['password'], $data['salt'], $data['hash'])) {
            return new JsonResponse(['error' => 'Les champs "password", "salt" et "hash" sont requis.'], 400);
        }

        $password = $data['password'];
        $salt = $data['salt'];
        $hash = $data['hash'];

        $isValid = $this->hashageService->verifyPassword($password, $salt, $hash);

        return new JsonResponse([
            'password' => $password,
            'salt' => $salt,
            'hash' => $hash,
            'valid' => $isValid
        ]);
    }
}
