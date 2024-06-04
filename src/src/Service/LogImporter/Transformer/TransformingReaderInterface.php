<?php

namespace App\Service\LogImporter\Transformer;

use App\DTO\Log;

interface TransformingReaderInterface
{
    /**
     * @return iterable<Log>
     */
    public function transform(string $pathname): iterable;
}
