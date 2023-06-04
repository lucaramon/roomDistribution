<?php

namespace App\Service;

use App\Repository\RoomRepository;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SingleRoomService extends AbstractController
{

    public function __construct(private readonly RoomRepository $roomRepository)
    {
    }

    #[ArrayShape(['Message' => "string", 'Room Number' => "mixed", 'Persons' => "array"])] public function getRoom(string $number): array
    {
        $room = $this->roomRepository->findOneBy(['number' => $number]);

        if (!$room){
            throw $this->createNotFoundException(
                'No room found for Room Number: '.$number);
        }
        $allPersons = [];
        $persons = $room->getPersons();

        foreach ($persons as $currentPerson){
            $allPersons[] = $currentPerson->jsonSerialize();
        }
        return [
            'Message' => 'The following Room has been found!',
            'Room Number' => $room->getNumber(),
            'Persons' => $allPersons,
        ];
    }
}
