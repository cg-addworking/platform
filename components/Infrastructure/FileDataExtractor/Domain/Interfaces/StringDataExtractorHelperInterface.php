<?php

namespace Components\Infrastructure\FileDataExtractor\Domain\Interfaces;

interface StringDataExtractorHelperInterface
{
    public function extractDataOfLinesStartingWith(string $content, string $needle): ?string;
    public function extractDataFromLinesFollowingLineStartingWith(string $content, string $needle): ?string;
    public function extractDataContains(string $contents, string $needle): bool;
}
