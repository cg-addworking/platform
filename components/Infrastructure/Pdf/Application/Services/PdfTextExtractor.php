<?php

namespace Components\Infrastructure\Pdf\Application\Services;

use Components\Infrastructure\Pdf\Domain\Interfaces\PdfTextExtractorInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class PdfTextExtractor implements PdfTextExtractorInterface
{
    public function hasText(\SplFileInfo $file): bool
    {
        return strlen(preg_replace('/\s+/', '', $this->getText($file))) > 0;
    }

    /**
     * requires ghostscript (gs) to be installed first
     *
     * Options explaination:
     *
     * -sDEVICE=txtwrite   - text writer
     * -sOutputFile=-      - use stdout instead of a file
     * -q                  - quiet - prevent writing normal messages to output
     * -dNOPAUSE           - disable prompt and pause at end of each page
     * -dBATCH             - indicates batch operation so exits at end of processing
     *
     * @see https://gist.github.com/drmohundro/560d72ed06baaf16f191ee8be34526ac
     */
    public function getText(\SplFileInfo $file): string
    {
        $process = new Process(
            ['gs', '-sDEVICE=txtwrite', '-sOutputFile=-', '-q', '-dNOPAUSE', '-dBATCH', $file->getPathname()]
        );

        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $process->getOutput();
    }
}
