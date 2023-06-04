<?php

namespace App\Tests\Controller;

use App\Controller\ImportController;
use App\Service\ImportService;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ImportControllerTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function indexReturnsExpectedJSONResponse(): void
    {
        self::markTestSkipped('Problems with Request');
        $service = $this->prophesize(ImportService::class);
        $service->writeToDatabase([])->shouldBeCalled()->willReturn([]);
        $importController = new ImportController($service->reveal());

        $csvString = '';
        $request = $this->prophesize(Request::class);
        $result = $importController->index($request);

        self::assertEquals(new JsonResponse([]), $result);
    }

}
