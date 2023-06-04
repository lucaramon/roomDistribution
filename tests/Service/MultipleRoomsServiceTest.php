<?php

namespace App\Tests\Service;

use App\Entity\Room;
use App\Repository\RoomRepository;
use App\Service\MultipleRoomsService;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MultipleRoomsServiceTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function getRoomsThrowsExceptionOnEmptyRoomRepository(): void
    {
        $roomRepositoryMock = $this->prophesize(RoomRepository::class);
        $roomRepositoryMock->findAll()->shouldBeCalled()->willReturn([]);
        $multipleRoomsService = new MultipleRoomsService($roomRepositoryMock->reveal());

        $this->expectException(NotFoundHttpException::class);

        $multipleRoomsService->getRooms();
    }

    /**
     * @test
     */
    public function getRoomsOnRoomRepository(): void
    {
        $room1 = new Room('9999');
        $room2 = new Room('7777');

        $roomCollection = [$room1, $room2];

        $expected = [
            'Message' => 'The following Rooms have been found!',
            'Rooms' => [['Room Number'=>$room1->getNumber(), 'Persons'=>[]],
                        ['Room Number'=>$room2->getNumber(), 'Persons'=>[]]]
        ];

        $roomRepositoryMock = $this->prophesize(RoomRepository::class);
        $roomRepositoryMock->findAll()->shouldBeCalled()->willReturn($roomCollection);
        $multipleRoomsService = new MultipleRoomsService($roomRepositoryMock->reveal());
        $result = $multipleRoomsService->getRooms();

        self::assertEquals($expected,$result);
    }
}
