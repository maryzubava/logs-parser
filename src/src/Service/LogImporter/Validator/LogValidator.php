<?php

namespace App\Service\LogImporter\Validator;

use App\DTO\Log;
use App\Exception\InvalidLogFormatException;

class LogValidator implements ValidatorInterface
{
    /**
     * @throws InvalidLogFormatException
     */
    public function validate(Log $log): void
    {
        if (false === in_array(
            $log->httpMethod,
            ['POST', 'GET', 'PUT', 'PATCH', 'DELETE', 'TRACE', 'HEAD', 'OPTIONS'],
        )) {
            throw new InvalidLogFormatException(sprintf('Invalid HTTP Method. HTTP Method: %s', $log->httpMethod));
        }

        if (false === ($log->statusCode > 100 && $log->statusCode < 600)) {
            throw new InvalidLogFormatException(sprintf('Invalid status code. Status code: %s', $log->statusCode));
        }
    }
}
