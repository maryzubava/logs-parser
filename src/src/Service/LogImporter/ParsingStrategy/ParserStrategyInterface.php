<?php

namespace App\Service\LogImporter\ParsingStrategy;

use App\DTO\Log;
use App\Exception\InvalidLogFormatException;

interface ParserStrategyInterface
{
    /**
     * @throws InvalidLogFormatException
     */
    public function parse(string $log): Log;
}
