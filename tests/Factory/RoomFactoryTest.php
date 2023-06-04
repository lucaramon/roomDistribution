<?php

namespace App\Tests\Factory;

use App\Factory\PersonFactory;
use App\Factory\RoomFactory;
use PHPUnit\Framework\TestCase;

class RoomFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function createMinimalRoomFromString(): void
    {
        $string = "1234";

        $factory = new RoomFactory(new PersonFactory());
        $room = $factory->create($string);
        self::assertSame("1234", $room->getNumber());
        self::assertEmpty($room->getPersons());
    }

    /**
     * @test
     */
    public function createRoomWithOnePersonFromString(): void
    {
        $string = '1106,Jan Stockfisch (jstockfisch)';

        $factory = new RoomFactory(new PersonFactory());
        $room = $factory->create($string);
        self::assertSame("1106", $room->getNumber());
        self::assertCount(1, $room->getPersons());
        $person = $room->getPersons()[0];
        self::assertSame('jstockfisch', $person->getUsername());
    }

    /**
     * @test
     */
    public function createRoomWithManyPersonsFromString(): void
    {
        $string = '1105,Marina Bortin (mbortin),Svenja Hilken (shilken),Florenz Buhrke (fbuhrke),';

        $factory = new RoomFactory(new PersonFactory());
        $room = $factory->create($string);
        self::assertSame("1105", $room->getNumber());
        self::assertCount(3, $room->getPersons());
        self::assertSame('mbortin', $room->getPersons()[0]->getUsername());
        self::assertSame('shilken', $room->getPersons()[1]->getUsername());
        self::assertSame('fbuhrke', $room->getPersons()[2]->getUsername());
    }
}
