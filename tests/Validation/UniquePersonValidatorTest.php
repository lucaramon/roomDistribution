<?php

namespace App\Tests\Validation;

use App\Factory\PersonFactory;
use App\Factory\RoomFactory;
use App\Validation\Exception\PersonAlreadyExistException;
use App\Validation\UniquePersonValidator;
use PHPUnit\Framework\TestCase;

class UniquePersonValidatorTest extends TestCase
{
    /**
     * @test
     */
    public function checkIfPersonAlreadyExist(): void
    {

        $this->expectException(PersonAlreadyExistException::class);

        $factory = new RoomFactory(new PersonFactory());
        $room1 = $factory->create("1111,Dennis Fischer (dfischer),,,");
        $room2 = $factory->create("1112,Nicolas Kolo (nkolo),Ramon Sanchez (rsanchez),Dennis Fischer (dfischer),");

        $roomCollection = [$room1, $room2];

        $validator = new UniquePersonValidator();
        $validator->validate(...$roomCollection);
    }
}
