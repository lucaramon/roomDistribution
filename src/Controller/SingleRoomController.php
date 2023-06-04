<?php

namespace App\Controller;

use App\Service\SingleRoomService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class SingleRoomController extends AbstractController
{

    public function __construct(private readonly SingleRoomService $singleRoomService)
    {
    }

    #[Route('/room/{number}', name: 'app_single_room', methods: 'GET')]
    public function index(string $number): JsonResponse
    {
        $roomInformation = $this->singleRoomService->getRoom($number);

        return new JsonResponse($roomInformation);
    }
}
