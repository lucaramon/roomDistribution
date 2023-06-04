<?php

namespace App\Tests\Entity;

use App\Entity\Person;
use App\Validation\Exception\InvalidTitleException;
use App\Validation\Exception\InvalidNameAdditionException;
use PHPUnit\Framework\TestCase;

class PersonTest extends TestCase
{

    /**
     * @test
     */
    public function createUserWithInvalidTitleFromString(): void
    {
        $this->expectException(InvalidTitleException::class);

        $person = new Person("Susanne", "Moog", "smoog");

        $person->setTitle("Doctor");

    }

    /**
     * @test
     */
    public function createUserWithInvalidNameAdditionFromString(): void
    {
        $this->expectException(InvalidNameAdditionException::class);

        $person = new Person("Susanne", "Moog", "smoog");

        $person->setNameAddition("dem");

    }
}
