<?php

namespace Components\Infrastructure\FileDataExtractor\Domain\Interfaces;

interface DocumentDetectorInterface
{
    public function detect(\SplFileInfo $file, float &$score = -1): bool;
}
