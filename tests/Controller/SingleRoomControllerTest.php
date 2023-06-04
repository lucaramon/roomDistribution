<?php

namespace App\Tests\Controller;

use App\Controller\SingleRoomController;
use App\Service\SingleRoomService;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Component\HttpFoundation\JsonResponse;

class SingleRoomControllerTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function indexReturnsExpectedJSONResponse(): void
    {
        $service = $this->prophesize(SingleRoomService::class);
        $service->getRoom('1111')->shouldBeCalled()->willReturn([]);
        $singleRoomsController = new SingleRoomController($service->reveal());
        $result = $singleRoomsController->index('1111');

        self::assertEquals(new JsonResponse([]), $result);
    }
}
