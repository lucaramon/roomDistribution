<?php

namespace App\Factory;

use App\Entity\Room;

class RoomFactory
{
    public function __construct(
        private readonly PersonFactory $personFactory
    )
    {
    }

    public function create(string $string): Room
    {
        $parts = explode(',', $string);
        $parts = array_filter($parts);

        $room = new Room(array_shift($parts));

        foreach ($parts as $part) {
            $room->addPerson($this->personFactory->create($part));
        }
        return $room;
    }
}
