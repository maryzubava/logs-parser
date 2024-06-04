<?php

namespace App\Service\LogImporter\ParsingStrategy;

use App\DTO\Log;
use App\Exception\InvalidLogFormatException;

final readonly class SubStringParserStrategy implements ParserStrategyInterface
{
    /**
     * @throws InvalidLogFormatException
     * @throws \Exception
     */
    public function parse(string $log): Log
    {
        $values = explode(' ', $log);

        if (9 !== count($values)) {
            throw new InvalidLogFormatException('Found unexpected amount of values.');
        }

        $dateTime = \DateTime::createFromFormat(
            'j/M/Y:H:i:s O',
            substr($values[3], 1).' '.substr($values[4], 0, mb_strlen($values[4]) - 1),
        );

        if (false === $dateTime) {
            throw new InvalidLogFormatException('Invalid date format.');
        }

        return new Log(
            serviceName: $values[0],
            dateTime: $dateTime,
            httpMethod: substr($values[5], 1),
            endpoint: $values[6],
            protocol: substr($values[7], 0, mb_strlen($values[7]) - 1),
            statusCode: (int) $values[8],
        );
    }
}
