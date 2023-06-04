<?php

namespace App\Service;

use App\Entity\Room;
use App\Factory\PersonFactory;
use App\Factory\RoomFactory;
use App\Validation\ChainedRoomValidator;
use Doctrine\Persistence\ManagerRegistry;
use JetBrains\PhpStorm\ArrayShape;

class ImportService
{

    public function __construct(private readonly ManagerRegistry $managerRegistry,
                                private readonly ChainedRoomValidator $chainedRoomValidator)
    {
    }

    #[ArrayShape(['message' => "string", 'path' => "string"])] public function writeToDatabase(array $csvData): array
    {
        $roomFactory = new RoomFactory(new PersonFactory());

        $roomCollection = [];

        foreach ($csvData as $currentLine) {
            $entityManager = $this->managerRegistry->getManager();
            $currentRoom = $roomFactory->create($currentLine);

            $roomCollection [] = $currentRoom;

            $room = new Room($currentRoom->getNumber());
            $currentRoomPersons = $currentRoom->getPersons();

            foreach ($currentRoomPersons as $currentPerson) {
                $currentPerson->setRoom($room);
                $entityManager->persist($currentPerson);
            }
            $this->chainedRoomValidator->validateAll(...$roomCollection);
            $entityManager->persist($room);
            $entityManager->flush();
        }
        return ['message' => 'Saved Data Successfully!'];
    }
}
