<?php

namespace App\Service\LogImporter\ParsingStrategy;

use App\DTO\Log;
use App\Exception\InvalidLogFormatException;

/**
 * This class was created as an option while log parsing.
 * This solution is more readable, but works not really fast.
 *
 * To check another option check implementations of the same interface
 */
final readonly class RegexParserStrategy implements ParserStrategyInterface
{
    /**
     * @throws \Exception
     */
    public function parse(string $log): Log
    {
        $matches = [];

        $isMatched = preg_match(
            '/^(.*) - - \[(\d+\/\w+\/\d+:\d+:\d+:\d+ \+\d+)\] "(\w+) (.+) (HTTP\/\d\.\d)" (\d+)$/',
            $log,
            $matches,
        );

        if (!$isMatched) {
            throw new InvalidLogFormatException();
        }

        $dateTime = \DateTime::createFromFormat(
            'j/M/Y:H:i:s O',
            $matches[2],
        );

        if (false === $dateTime) {
            throw new InvalidLogFormatException('Invalid date format');
        }

        return new Log(
            serviceName: $matches[1],
            dateTime: $dateTime,
            httpMethod: $matches[3],
            endpoint: $matches[4],
            protocol: $matches[5],
            statusCode: (int) $matches[6],
        );
    }
}
