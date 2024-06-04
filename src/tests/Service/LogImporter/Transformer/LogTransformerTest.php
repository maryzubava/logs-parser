<?php

namespace App\Tests\Service\LogImporter\Transformer;

use App\DTO\Log;
use App\Service\LogImporter\ParsingStrategy\SubStringParserStrategy;
use App\Service\LogImporter\Transformer\LogTransformer;
use App\Service\Reader\ReaderInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

/**
 * @internal
 */
class LogTransformerTest extends TestCase
{
    public function testTransformMethodTransformsLogsCorrectly(): void
    {
        $reader = $this->createMock(ReaderInterface::class);
        $parser = new SubStringParserStrategy();

        $firstDate = '17/Aug/2018:09:29:11 +0000';
        $secondDate = '18/Aug/2018:09:29:11 +0000';

        $firstLog = sprintf('USER-SERVICE - - [%s] "GET /users HTTP/1.1" 200', $firstDate);
        $secondLog = sprintf('INVOICE-SERVICE - - [%s] "POST /invoices HTTP/1.1" 400', $secondDate);

        $firstLogDto = new Log('USER-SERVICE', \DateTime::createFromFormat('j/M/Y:H:i:s O', $firstDate), 'GET', '/users', 'HTTP/1.1', 200);
        $secondLogDto = new Log('INVOICE-SERVICE', \DateTime::createFromFormat('j/M/Y:H:i:s O', $secondDate), 'POST', '/invoices', 'HTTP/1.1', 400);

        $reader->expects($this->once())
            ->method('read')
            ->willReturn([$firstLog, $secondLog])
        ;

        $transformer = new LogTransformer($reader, $parser, $this->createMock(LoggerInterface::class));

        $transformedLogs = iterator_to_array($transformer->transform('logs.txt'));

        $this->assertEquals([$firstLogDto, $secondLogDto], $transformedLogs);
    }
}
