<?php

namespace Components\Infrastructure\Image\Domain\Interfaces;

interface ImageTextExtractorInterface
{
    public function getText(\SplFileInfo $file): string;
}
