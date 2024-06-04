<?php

namespace App\Repository;

use App\DTO\CountFilter;
use App\Entity\Log;

interface LogRepositoryInterface
{
    public function getCountByFilter(CountFilter $countFilter): int;

    public function save(Log ...$logs): void;

    public function truncate(): void;
}
