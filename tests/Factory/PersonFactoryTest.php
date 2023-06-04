<?php
declare(strict_types=1);

namespace App\Tests\Factory;

use App\Factory\PersonFactory;
use PHPUnit\Framework\TestCase;

final class PersonFactoryTest extends TestCase
{
    private $factory;

    /**
     * @test
     */
    public function createMinimalUserFromString(): void
    {
        $string = 'Susanne Moog (smoog)';

        $person = $this->factory->create($string);

        self::assertSame('Susanne', $person->getFirstname());
        self::assertSame('Moog', $person->getLastname());
        self::assertSame('smoog', $person->getUsername());
    }
    /**
     * @test
     */
    public function createAnotherUserFromString(): void
    {
        $string = 'Dennis Fischer (dfischer)';

        $person = $this->factory->create($string);

        self::assertSame('Dennis', $person->getFirstname());
        self::assertSame('Fischer', $person->getLastname());
        self::assertSame('dfischer', $person->getUsername());
    }

    /**
     * @test
     */
    public function createUserWithNameAdditionFromString(): void
    {
        $string = 'Susanne van Moog (smoog)';

        $person = $this->factory->create($string);

        self::assertSame('Susanne', $person->getFirstname());
        self::assertSame('van', $person->getNameAddition());
        self::assertSame('Moog', $person->getLastname());
        self::assertSame('smoog', $person->getUsername());
    }

    /**
     * @test
     */
    public function createUserWithTitleFromString(): void
    {
        $string = 'Dr. Susanne Moog (smoog)';

        $person = $this->factory->create($string);

        self::assertSame('Dr.', $person->getTitle());
        self::assertSame('Susanne', $person->getFirstname());
        self::assertSame('Moog', $person->getLastname());
        self::assertSame('smoog', $person->getUsername());
    }

    /**
     * @test
     */
    public function createUserWithTitleAndNameAdditionFromString(): void
    {
        $string = 'Dr. Susanne van Moog (smoog)';

        $person = $this->factory->create($string);

        self::assertSame('Dr.', $person->getTitle());
        self::assertSame('Susanne', $person->getFirstname());
        self::assertSame('van', $person->getNameAddition());
        self::assertSame('Moog', $person->getLastname());
        self::assertSame('smoog', $person->getUsername());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->factory = new PersonFactory();
    }
}
