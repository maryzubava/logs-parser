<?php

namespace App\Tests\Service\Validator;

use App\DTO\CountFilter;
use App\Service\Validator\CountFilterValidator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * @internal
 */
class CountFilterValidatorTest extends TestCase
{
    public function testValidateMethodThrowsExceptionForInvalidStatusCode(): void
    {
        $countFilter = new CountFilter(
            statusCode: '200status'
        );

        $validator = new CountFilterValidator();

        $this->expectException(BadRequestHttpException::class);
        $validator->validate($countFilter);
    }

    public function testValidateMethodThrowsExceptionForInvalidStartDate(): void
    {
        $countFilter = new CountFilter(
            startDate: 'random string',
        );

        $validator = new CountFilterValidator();

        $this->expectException(BadRequestHttpException::class);
        $validator->validate($countFilter);
    }

    public function testValidateMethodThrowsExceptionForInvalidEndDate(): void
    {
        $countFilter = new CountFilter(
            endDate: 'random string',
        );

        $validator = new CountFilterValidator();

        $this->expectException(BadRequestHttpException::class);
        $validator->validate($countFilter);
    }
}
