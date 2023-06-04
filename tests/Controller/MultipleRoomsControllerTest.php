<?php

namespace App\Tests\Controller;

use App\Controller\MultipleRoomsController;
use App\Service\MultipleRoomsService;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Component\HttpFoundation\JsonResponse;

class MultipleRoomsControllerTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function indexReturnsExpectedJSONResponse(): void
    {
        $service = $this->prophesize(MultipleRoomsService::class);
        $service->getRooms()->shouldBeCalled()->willReturn([]);
        $multipleRoomsController = new MultipleRoomsController($service->reveal());
        $result = $multipleRoomsController->index();

        self::assertEquals(new JsonResponse([]), $result);
    }
}
