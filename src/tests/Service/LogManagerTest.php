<?php

namespace Service;

use App\DTO\CountFilter;
use App\Repository\LogRepositoryInterface;
use App\Service\LogManager;
use App\Service\Validator\CountFilterValidator;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class LogManagerTest extends TestCase
{
    protected LogRepositoryInterface $logRepository;
    private CountFilterValidator $countFilterValidator;

    protected function setUp(): void
    {
        $this->logRepository = $this->createMock(LogRepositoryInterface::class);
        $this->countFilterValidator = new CountFilterValidator();
    }

    public function testCountMethodReturnsCountBasedOnFilter()
    {
        $countFilter = new CountFilter(['USER-SERVICE']);

        $this->logRepository->expects($this->once())
            ->method('getCountByFilter')
            ->with($countFilter)
            ->willReturn(10)
        ;

        $logManager = new LogManager($this->logRepository, $this->countFilterValidator);

        $count = $logManager->count($countFilter);

        $this->assertEquals(10, $count);
    }

    public function testTruncateMethodTruncatesLogRepository()
    {
        $this->logRepository->expects($this->once())
            ->method('truncate')
        ;

        $logManager = new LogManager($this->logRepository, $this->countFilterValidator);

        $logManager->truncate();
    }
}
