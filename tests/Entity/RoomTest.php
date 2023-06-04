<?php

namespace App\Tests\Entity;

use App\Entity\Room;
use App\Validation\Exception\InvalidNumberException;
use PHPUnit\Framework\TestCase;

class RoomTest extends TestCase
{
    /**
     * @test
     */
    public function createRoomWithInvalidNumberFromString(): void
    {
        $this->expectException(InvalidNumberException::class);

        new Room("");
    }
}
