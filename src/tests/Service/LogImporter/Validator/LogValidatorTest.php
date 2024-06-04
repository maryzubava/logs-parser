<?php

namespace App\Tests\Service\LogImporter\Validator;

use App\DTO\Log;
use App\Exception\InvalidLogFormatException;
use App\Service\LogImporter\Validator\LogValidator;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class LogValidatorTest extends TestCase
{
    public function testValidateMethodThrowsExceptionForInvalidHttpMethod(): void
    {
        $validator = new LogValidator();

        $log = new Log(
            serviceName: 'USER-SERVICE',
            dateTime: new \DateTime(),
            httpMethod: 'INVALID_METHOD',
            endpoint: '/test',
            protocol: 'HTTP/1.1',
            statusCode: 200,
        );

        $this->expectException(InvalidLogFormatException::class);
        $validator->validate($log);
    }

    public function testValidateMethodThrowsExceptionForInvalidStatusCode(): void
    {
        $validator = new LogValidator();

        $log = new Log(
            serviceName: 'USER-SERVICE',
            dateTime: new \DateTime(),
            httpMethod: 'POST',
            endpoint: '/test',
            protocol: 'HTTP/1.1',
            statusCode: 700,
        );

        $this->expectException(InvalidLogFormatException::class);
        $validator->validate($log);
    }

    public function testValidateMethodDoesNotThrowExceptionForValidLog(): void
    {
        $validator = new LogValidator();

        $log = new Log(
            serviceName: 'USER-SERVICE',
            dateTime: new \DateTime(),
            httpMethod: 'GET',
            endpoint: '/test',
            protocol: 'HTTP/1.1',
            statusCode: 200,
        );

        $this->expectNotToPerformAssertions();
        $validator->validate($log);
    }
}
