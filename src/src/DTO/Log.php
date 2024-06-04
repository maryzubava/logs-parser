<?php

namespace App\DTO;

final readonly class Log
{
    public function __construct(
        public string $serviceName,
        public \DateTimeInterface $dateTime,
        public string $httpMethod,
        public string $endpoint,
        public string $protocol,
        public int $statusCode,
    ) {}
}
