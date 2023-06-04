<?php

namespace App\Validation;

use App\Entity\Room;

class ChainedRoomValidator
{
    //protected RoomNumberValidator $roomNumberValidator;
    protected UniqueRoomNumberValidator $uniqueRoomNumberValidator;
    protected UniquePersonValidator $uniquePersonValidator;

    public function __construct(
        //RoomNumberValidator $roomNumberValidator = null,
        UniqueRoomNumberValidator $uniqueRoomNumberValidator = null,
        UniquePersonValidator $uniquePersonValidator = null
    )
    {
        //$this->roomNumberValidator = $roomNumberValidator ?: new RoomNumberValidator();
        $this->uniqueRoomNumberValidator = $uniqueRoomNumberValidator ?: new UniqueRoomNumberValidator();
        $this->uniquePersonValidator = $uniquePersonValidator ?: new UniquePersonValidator();
    }

    public function validateAll(Room ...$rooms): void
    {
        //$this->roomNumberValidator->validate();
        $this->uniqueRoomNumberValidator->validate(...$rooms);
        $this->uniquePersonValidator->validate(...$rooms);
    }
}
