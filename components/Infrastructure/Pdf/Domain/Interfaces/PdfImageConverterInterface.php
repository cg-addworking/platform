<?php

namespace Components\Infrastructure\Pdf\Domain\Interfaces;

interface PdfImageConverterInterface
{
    public function convert(\SplFileInfo $file): \SplFileInfo;
}
