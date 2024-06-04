<?php

namespace App\Service\LogImporter\Filter;

use App\Exception\InvalidLogFormatException;
use App\Service\LogImporter\Validator\LogValidator;
use Psr\Log\LoggerInterface;

final readonly class LogFilterIterator implements FilteringIteratorInterface
{
    public function __construct(
        private LogValidator $logValidator,
        private LoggerInterface $logger,
    ) {}

    public function filter(iterable $logs): iterable
    {
        foreach ($logs as $log) {
            try {
                $this->logValidator->validate($log);

                yield $log;
            } catch (InvalidLogFormatException $exception) {
                $this->logger->warning('Log validation error: '.$exception->getMessage());
            }
        }
    }
}
