<?php

namespace App\Tests\Service\LogImporter\ParsingStrategy;

use App\Exception\InvalidLogFormatException;
use App\Service\LogImporter\ParsingStrategy\RegexParserStrategy;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class RegexParserStrategyTest extends TestCase
{
    public function testParseFunctionCorrectlyParsesValidLogString(): void
    {
        $parser = new RegexParserStrategy();

        $logString = 'USER-SERVICE - - [17/Aug/2018:09:21:54 +0000] "GET /users HTTP/1.1" 200';

        $parsedLog = $parser->parse($logString);

        $this->assertEquals('USER-SERVICE', $parsedLog->serviceName);
        $this->assertEquals((new \DateTime('2018-08-17 09:21:54'))->getTimestamp(), $parsedLog->dateTime->getTimestamp());
        $this->assertEquals('GET', $parsedLog->httpMethod);
        $this->assertEquals('/users', $parsedLog->endpoint);
        $this->assertEquals('HTTP/1.1', $parsedLog->protocol);
        $this->assertEquals(200, $parsedLog->statusCode);
    }

    public function testInvalidLogFormatExceptionIsThrownForInvalidLogString(): void
    {
        $parser = new RegexParserStrategy();

        $logString = 'Invalid log';

        $this->expectException(InvalidLogFormatException::class);

        $parser->parse($logString);
    }
}
