<?php

namespace App\Tests\Service;

use App\Service\ImportService;
use App\Validation\ChainedRoomValidator;
use App\Validation\Exception\PersonAlreadyExistException;
use Doctrine\Persistence\ObjectManager;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Bridge\Doctrine\ManagerRegistry;

class ImportServiceTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function insertValidDataIntoDatabase(): void
    {
        $csvData = ['9999,Manuel Meier (mmeier),Bjorn Larson (blarson)',
            '7777,Daniela Muller (dmuller),Simon See (ssee)'];

        $objectManagerMock = $this->prophesize(ObjectManager::class);
        $objectManagerMock->persist(Argument::any())->shouldBeCalledTimes(6);
        $objectManagerMock->flush()->shouldBeCalledTimes(2);

        $managerRegistryMock = $this->prophesize(ManagerRegistry::class);
        $managerRegistryMock->getManager()->shouldBeCalled()->willReturn($objectManagerMock->reveal());

        $chainedRoomValidatorMock = $this->prophesize(ChainedRoomValidator::class);
        $chainedRoomValidatorMock->validateAll(Argument::cetera())->shouldBeCalled();

        $importService = new ImportService($managerRegistryMock->reveal(), $chainedRoomValidatorMock->reveal());
        $importService->writeToDatabase($csvData);
    }

    /**
     * @test
     */
    public function insertInvalidDataIntoDatabase(): void
    {
        $this->expectException(PersonAlreadyExistException::class);

        $csvData = ['9999,Manuel Meier (mmeier),Bjorn Larson (blarson)',
            '7777,Michael Meier (mmeier),Simon See (ssee)'];

        $objectManagerMock = $this->prophesize(ObjectManager::class);

        $managerRegistryMock = $this->prophesize(ManagerRegistry::class);
        $managerRegistryMock->getManager()->shouldBeCalled()->willReturn($objectManagerMock->reveal());

        $chainedRoomValidatorMock = $this->prophesize(ChainedRoomValidator::class);
        $chainedRoomValidatorMock->validateAll(Argument::cetera())->shouldBeCalled()->willThrow(PersonAlreadyExistException::class);

        $importService = new ImportService($managerRegistryMock->reveal(), $chainedRoomValidatorMock->reveal());
        $importService->writeToDatabase($csvData);
    }
}
