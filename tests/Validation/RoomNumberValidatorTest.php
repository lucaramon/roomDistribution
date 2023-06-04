<?php

namespace App\Tests\Validation;

use App\Validation\Exception\InvalidNumberException;
use App\Validation\RoomNumberValidator;
use PHPUnit\Framework\TestCase;

class RoomNumberValidatorTest extends TestCase
{
    /**
     * @test
     */
    public function checkIfRoomNumberAlreadyExist(): void
    {

        $this->expectException(InvalidNumberException::class);

        $validator = new RoomNumberValidator();
        $validator->validate("22222");
    }
}
