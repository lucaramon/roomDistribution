<?php

namespace App\Controller;

use App\Service\MultipleRoomsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class MultipleRoomsController extends AbstractController
{

    public function __construct(private readonly MultipleRoomsService $multipleRoomsService)
    {
    }

    #[Route('/room', name: 'app_multiple_rooms', methods: 'GET')]
    public function index(): JsonResponse
    {
        $allRooms = $this->multipleRoomsService->getRooms();

        return new JsonResponse($allRooms);
    }
}
