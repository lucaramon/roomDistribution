<?php

namespace App\Controller;

use App\Service\ImportService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ImportController extends AbstractController
{

    public function __construct(private readonly ImportService $importService)
    {
    }

    #[Route('/import', name: 'app_import', methods: 'POST')]
    public function index(Request $request): JsonResponse
    {
        //$csvData = array_filter(explode("\r\n", $request->files->get('File')));
        $csvData = array_filter(explode("\r\n", $_POST['File']));
        $importResponse = $this->importService->writeToDatabase($csvData);

        return new JsonResponse($importResponse);
    }
}
