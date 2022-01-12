<?php

namespace Components\Infrastructure\Text\Domain\Interfaces;

interface TextExtractorServiceInterface
{
    public function getContents(\SplFileInfo $file, bool $is_pdf_image = false): string;

    public function getLines(\SplFileInfo $file): array;
}
