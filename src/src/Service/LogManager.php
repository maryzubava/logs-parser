<?php

namespace App\Service;

use App\DTO\CountFilter;
use App\Repository\LogRepositoryInterface;
use App\Service\Validator\CountFilterValidator;

final readonly class LogManager
{
    public function __construct(
        private LogRepositoryInterface $logRepository,
        private CountFilterValidator $countFilterValidator,
    ) {}

    public function count(CountFilter $countFilter): int
    {
        $this->countFilterValidator->validate($countFilter);

        return $this->logRepository->getCountByFilter($countFilter);
    }

    public function truncate(): void
    {
        $this->logRepository->truncate();
    }
}
