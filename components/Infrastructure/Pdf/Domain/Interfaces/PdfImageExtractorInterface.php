<?php

namespace Components\Infrastructure\Pdf\Domain\Interfaces;

interface PdfImageExtractorInterface
{
    public function hasImages(\SplFileInfo $file): bool;

    public function listImages(\SplFileInfo $file): array;

    public function getImages(\SplFileInfo $file): \Generator;
}
