<?php

namespace Components\Infrastructure\Pdf\Application\Services;

use Components\Infrastructure\Pdf\Domain\Interfaces\PdfImageExtractorInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class PdfImageExtractor implements PdfImageExtractorInterface
{
    public function hasImages(\SplFileInfo $file): bool
    {
        return count(array_filter($this->listImages($file), fn($f) => $f->type == 'image')) != 0;
    }

    public function listImages(\SplFileInfo $file): array
    {
        $process = new Process(
            ['pdfimages', '-list', $file->getPathname()]
        );

        $process->run();

        // executes after the command finishes
        if (! $process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $this->parseImageListing($process->getOutput());
    }

    /**
     * requires poppler-utils to be installed first
     *
     * Options explaination:
     *
     * -j                  - output files as JPEG
     *
     * @see https://askubuntu.com/questions/150100/extracting-embedded-images-from-a-pdf
     */
    public function getImages(\SplFileInfo $file): \Generator
    {
        $tmp = sys_get_temp_dir();
        $dir = uniqid("{$tmp}/pdfimageextractor");

        if (! mkdir($dir, 0777, true)) {
            throw new \RuntimeException("unable to create dir '{$dir}'");
        }

        $process = new Process(
            ['pdfimages', '-j', $file->getPathname(), "{$dir}/"]
        );

        $process->run();

        // executes after the command finishes
        if (! $process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $it = new \DirectoryIterator($dir);
        $it = new \CallbackFilterIterator($it, fn($f) => $f->isFile() && !$f->isDot());

        yield from $it;
    }

    /**
     * Note: The aspect ratio (width:height) of A4 paper is 1:1.4142 (1:√2).
     */
    protected function parseImageListing(string $output): array
    {
        $result  = [];
        $output  = explode("\n", trim($output));
        $headers = preg_split('/\s+/', trim($output[0]));

        foreach (array_slice($output, 2) as $line) {
            $result[] = (object) array_combine($headers, preg_split('/\s+/', trim($line)));
        }

        return $result;
    }
}
