<?php

namespace Components\Infrastructure\Pdf\Application\Services;

use Components\Infrastructure\Pdf\Domain\Interfaces\PdfImageConverterInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class PdfImageConverter implements PdfImageConverterInterface
{
    /**
     * requires poppler-utils to be installed first
     *
     * Options explaination:
     *
     * -jpeg               - output files as JPEG
     * -singlefile         - write only the first page and do not add digits
     *
     * @see https://www.linuxuprising.com/2019/03/how-to-convert-pdf-to-image-png-jpeg.html
     */
    public function convert(\SplFileInfo $file): \SplFileInfo
    {
        $tmp  = sys_get_temp_dir();
        $path = uniqid("{$tmp}/");

        $process = new Process(
            ['pdftoppm', '-jpeg', '-singlefile', $file->getPathname(), $path]
        );

        $process->run();

        // executes after the command finishes
        if (! $process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return new \SplFileInfo("{$path}.jpg");
    }
}
