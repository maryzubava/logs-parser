<?php

namespace App\Controller;

use App\DTO\CountFilter;
use App\Service\LogManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Annotation\Route;

final class LogController extends AbstractController
{
    public function __construct(
        private readonly LogManager $logManager,
    ) {}

    #[Route('/count', name: 'app_count')]
    public function index(
        #[MapQueryString] CountFilter $countRequest = new CountFilter(),
    ): JsonResponse {
        return $this->json([
            'counter' => $this->logManager->count($countRequest),
        ]);
    }

    #[Route('/delete', name: 'app_truncate', methods: ['DELETE'])]
    public function truncate(): JsonResponse
    {
        $this->logManager->truncate();

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
