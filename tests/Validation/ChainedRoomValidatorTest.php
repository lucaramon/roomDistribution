<?php
declare(strict_types=1);

namespace App\Tests\Validation;

use App\Validation\ChainedRoomValidator;
use App\Validation\UniquePersonValidator;
use App\Validation\UniqueRoomNumberValidator;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

class ChainedRoomValidatorTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function validateAllUsesAllValidators(): void
    {
        //$roomNumberValidatorMock = $this->prophesize(RoomNumberValidator::class);
        $uniqueRoomNumberValidatorMock = $this->prophesize(UniqueRoomNumberValidator::class);
        $uniquePersonValidatorMock = $this->prophesize(UniquePersonValidator::class);

        //$roomNumberValidatorMock->validate(Argument::any())->shouldBeCalled();
        $uniqueRoomNumberValidatorMock->validate(Argument::any())->shouldBeCalled();
        $uniquePersonValidatorMock->validate(Argument::any())->shouldBeCalled();

        $chainedRoomValidator = new ChainedRoomValidator(
            //$roomNumberValidatorMock->reveal(),
            $uniqueRoomNumberValidatorMock->reveal(),
            $uniquePersonValidatorMock->reveal()
        );
        $chainedRoomValidator->validateAll();
    }
}
