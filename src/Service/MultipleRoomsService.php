<?php

namespace App\Service;

use App\Repository\RoomRepository;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MultipleRoomsService extends AbstractController
{

    public function __construct(private readonly RoomRepository $roomRepository)
    {
    }

    #[ArrayShape(['Message' => "string", 'Rooms' => "array"])] public function getRooms(): array
    {
        $room = $this->roomRepository->findAll();

        if (!$room) {
            throw $this->createNotFoundException(
                'No rooms found');
        }
        $allRooms = [];
        foreach ($room as $currentRoom) {
            $allPersons = [];
            $persons = $currentRoom->getPersons();

            foreach ($persons as $currentPerson) {
                $allPersons[] = $currentPerson->jsonSerialize();
            }
            $roomInformation = ['Room Number' => $currentRoom->getNumber(), 'Persons' => $allPersons];
            $allRooms[] = $roomInformation;
        }
        return [
            'Message' => 'The following Rooms have been found!',
            'Rooms' => $allRooms,
        ];
    }
}
