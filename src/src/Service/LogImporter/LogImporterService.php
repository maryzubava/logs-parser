<?php

namespace App\Service\LogImporter;

use App\Entity\Log;
use App\Repository\LogRepositoryInterface;
use App\Service\LogImporter\Filter\FilteringIteratorInterface;
use App\Service\LogImporter\Transformer\TransformingReaderInterface;

final readonly class LogImporterService
{
    public function __construct(
        private TransformingReaderInterface $transformingReader,
        private FilteringIteratorInterface $filteringIterator,
        private LogRepositoryInterface $logRepository,
        private int $batchSize,
    ) {
        if ($batchSize < 1) {
            throw new \UnexpectedValueException(sprintf('Batch size should be more than zero, (%s) passed.', $this->batchSize));
        }
    }

    public function import(string $pathname): void
    {
        $logs = $this->transformingReader->transform($pathname);

        $entities = [];

        foreach ($this->filteringIterator->filter($logs) as $log) {
            $entities[] = new Log($log);

            if (count($entities) === $this->batchSize) {
                $this->logRepository->save(...$entities);
                $entities = [];
            }
        }

        if (0 !== count($entities)) {
            $this->logRepository->save(...$entities);
        }
    }
}
