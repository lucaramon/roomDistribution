<?php

namespace App\Tests\Validation;

use App\Entity\Room;
use App\Validation\UniqueRoomNumberValidator;
use App\Validation\Exception\RoomNumberAlreadyExistException;
use PHPUnit\Framework\TestCase;

class UniqueRoomNumberValidatorTest extends TestCase
{
    /**
     * @test
     */
    public function checkIfRoomNumberAlreadyExist(): void
    {
        $this->expectException(RoomNumberAlreadyExistException::class);

        $room1 = new Room("1111");
        $room2 = new Room("1111");

        $roomCollection = [$room1, $room2];

        $validator = new UniqueRoomNumberValidator();
        $validator->validate(...$roomCollection);
    }
}
