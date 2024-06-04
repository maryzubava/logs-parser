<?php

namespace App\Service\Reader;

use App\Exception\FileNotFoundException;

final readonly class FileReader implements ReaderInterface
{
    /**
     * @throws FileNotFoundException
     */
    public function read(string $pathname): iterable
    {
        $stream = fopen($pathname, 'r+');

        if (!$stream) {
            throw new FileNotFoundException();
        }

        // Remove BOM
        if (!feof($stream)) {
            yield trim(str_replace("\xEF\xBB\xBF", '', (string) fgets($stream)));
        }

        while (!feof($stream)) {
            yield trim((string) fgets($stream));
        }

        fclose($stream);
    }
}
