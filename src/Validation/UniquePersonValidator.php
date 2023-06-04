<?php

namespace App\Validation;

use App\Validation\Exception\PersonAlreadyExistException;
use App\Entity\Room;

class UniquePersonValidator
{
    public function validate(Room ...$rooms): void
    {
        $allUsernames = [];
        foreach ($rooms as $currentRoom) {
            foreach ($currentRoom->getPersons() as $currentPerson) {
                $currentUsername = $currentPerson->getUsername();
                if (in_array($currentUsername, $allUsernames, true)) {
                    throw new PersonAlreadyExistException();
                }
                $allUsernames[] = $currentUsername;
            }
        }
    }
}
