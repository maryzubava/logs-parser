<?php

namespace App\Tests\Service\LogImporter\Filter;

use App\DTO\Log;
use App\Exception\InvalidLogFormatException;
use App\Service\LogImporter\Filter\LogFilterIterator;
use App\Service\LogImporter\Validator\LogValidator;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

/**
 * @internal
 */
class LogFilterIteratorTest extends TestCase
{
    public function testFilterMethodFiltersLogsCorrectly(): void
    {
        $validator = $this->createMock(LogValidator::class);
        $logger = $this->createMock(LoggerInterface::class);

        $firstLog = new Log('USER-SERVICE', new \DateTime(), 'POST', '/users', 'HTTP/1.1', 201);
        $secondLog = new Log('INVOICE-SERVICE', new \DateTime(), 'POST', '/invoices', 'HTTP/1.1', 400);

        $logs = [$firstLog, $secondLog];

        $validator->expects($this->exactly(2))
            ->method('validate')
            ->willReturnOnConsecutiveCalls(
                $this->returnValue(null),
                $this->throwException(new InvalidLogFormatException())
            )
        ;

        $logger->expects($this->once())
            ->method('warning')
        ;

        $filter = new LogFilterIterator($validator, $logger);

        foreach ($filter->filter($logs) as $logFiltered) {
            $this->assertSame($firstLog, $logFiltered);
        }
    }

    public function testFilterMethodFiltersLogsCorrectlyWithCorrectLogsIntegration(): void
    {
        $validator = new LogValidator();
        $logger = $this->createMock(LoggerInterface::class);

        $firstLog = new Log('USER-SERVICE', new \DateTime(), 'POST', '/users', 'HTTP/1.1', 201);
        $secondLog = new Log('INVOICE-SERVICE', new \DateTime(), 'POST', '/invoices', 'HTTP/1.1', 400);

        $logs = [$firstLog, $secondLog];

        $filter = new LogFilterIterator($validator, $logger);

        $logsFiltered = iterator_to_array($filter->filter($logs));

        $this->assertSame($logs, $logsFiltered);
    }

    public function testFilterMethodFiltersLogsCorrectlyWithIncorrectLogsIntegration(): void
    {
        $validator = new LogValidator();
        $logger = $this->createMock(LoggerInterface::class);

        $firstLog = new Log('USER-SERVICE', new \DateTime(), 'POST', '/users', 'HTTP/1.1', 201);
        $secondLog = new Log('INVOICE-SERVICE', new \DateTime(), 'POST', '/invoices', 'HTTP/1.1', 4060);

        $validLogs = [$firstLog];

        $filter = new LogFilterIterator($validator, $logger);

        $logsFiltered = [];
        foreach ($filter->filter([$firstLog, $secondLog]) as $logFiltered) {
            $logsFiltered[] = $logFiltered;
        }

        $this->assertSame($validLogs, $logsFiltered);
    }
}
