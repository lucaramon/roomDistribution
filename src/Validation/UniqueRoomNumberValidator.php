<?php

namespace App\Validation;

use App\Validation\Exception\RoomNumberAlreadyExistException;
use App\Entity\Room;

class UniqueRoomNumberValidator
{
    public function validate(Room ...$rooms): void
    {
        $allNumbers = [];
        foreach ($rooms as $currentRoom){
            if(in_array($currentRoom->getNumber(), $allNumbers, true)){
            throw new RoomNumberAlreadyExistException();
            }
            $allNumbers[] = $currentRoom->getNumber();
        }
    }
}
