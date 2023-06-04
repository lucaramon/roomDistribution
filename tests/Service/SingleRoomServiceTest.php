<?php

namespace App\Tests\Service;

use App\Entity\Room;
use App\Repository\RoomRepository;
use App\Service\SingleRoomService;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SingleRoomServiceTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function getRoomThrowsExceptionOnEmptyRoomRepository(): void
    {
        $roomRepositoryMock = $this->prophesize(RoomRepository::class);
        $roomRepositoryMock->findOneBy(['number' => '9999'])->shouldBeCalled()->willReturn([]);
        $singleRoomService = new SingleRoomService($roomRepositoryMock->reveal());

        $this->expectException(NotFoundHttpException::class);

        $singleRoomService->getRoom('9999');
    }

    /**
     * @test
     */
    public function getRoomOnRoomRepository(): void
    {
        $room = new Room('9999');

        $expected = [
            'Message' => 'The following Room has been found!',
            'Room Number' => $room->getNumber(),
            'Persons' => []
        ];

        $roomRepositoryMock = $this->prophesize(RoomRepository::class);
        $roomRepositoryMock->findOneBy(['number' => '9999'])->shouldBeCalled()->willReturn($room);
        $singleRoomService = new SingleRoomService($roomRepositoryMock->reveal());
        $result = $singleRoomService->getRoom('9999');

        self::assertEquals($expected, $result);
    }
}
