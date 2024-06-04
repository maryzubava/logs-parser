<?php

namespace App\Service\LogImporter\Transformer;

use App\Exception\InvalidLogFormatException;
use App\Service\LogImporter\ParsingStrategy\ParserStrategyInterface;
use App\Service\Reader\ReaderInterface;
use Psr\Log\LoggerInterface;

final readonly class LogTransformer implements TransformingReaderInterface
{
    public function __construct(
        private ReaderInterface $reader,
        private ParserStrategyInterface $parserStrategy,
        private LoggerInterface $logger,
    ) {}

    public function transform(string $pathname): iterable
    {
        foreach ($this->reader->read($pathname) as $i => $log) {
            if (empty($log)) {
                continue;
            }

            try {
                yield $this->parserStrategy->parse($log);
            } catch (InvalidLogFormatException $e) {
                $this->logger->warning('Skipping unprocessable log entry.', [
                    'line' => $i,
                    'log' => $log,
                ]);
            }
        }
    }
}
