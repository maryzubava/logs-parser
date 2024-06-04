<?php

namespace App\Service\Reader;

interface ReaderInterface
{
    /**
     * @return iterable<string>
     */
    public function read(string $pathname): iterable;
}
