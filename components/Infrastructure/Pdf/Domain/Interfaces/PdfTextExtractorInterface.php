<?php

namespace Components\Infrastructure\Pdf\Domain\Interfaces;

interface PdfTextExtractorInterface
{
    public function hasText(\SplFileInfo $file): bool;

    public function getText(\SplFileInfo $file): string;
}
