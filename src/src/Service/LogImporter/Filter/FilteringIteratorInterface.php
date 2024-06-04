<?php

namespace App\Service\LogImporter\Filter;

use App\DTO\Log;

interface FilteringIteratorInterface
{
    /**
     * @param iterable<Log> $logs
     *
     * @return iterable<Log>
     */
    public function filter(iterable $logs): iterable;
}
