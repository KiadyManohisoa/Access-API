<?php 


    namespace App\Service;

    use Symfony\Component\HttpFoundation\JsonResponse;

    class ReponseJSON {

        public function __construct()
        {}

        public function render(int $status, ?string $error, ?array $data) : JsonResponse{

            return new JsonResponse( [
                    'status' => $status,
                    'data' => $data,
                    'error' => $error
                ]

            );
        }
    
    }
?>
