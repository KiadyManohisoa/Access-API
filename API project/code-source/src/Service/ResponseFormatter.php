<?php 

namespace App\Service;
use Symfony\Component\HttpFoundation\JsonResponse;

class ResponseFormatter {

    public function formatResponsetoJson(mixed $data, string $status, ?string $error): JsonResponse {
        $response = [
            'status' => $status,
            'data' => $data,
            'error' => $error
        ];

        return new JsonResponse($response);
    }


}
?>