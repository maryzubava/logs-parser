<?php

namespace App\DTO;

final readonly class CountFilter
{
    /**
     * @param array<string>|null $serviceNames
     */
    public function __construct(
        public ?array $serviceNames = null,
        public ?string $statusCode = null,
        public ?string $startDate = null,
        public ?string $endDate = null,
    ) {}
}
