<?php

namespace Components\Common\WYSIWYG\Domain\Interfaces\Repositories;

interface WysiwygRepositoryInterface
{
    public function formatTextForPdf(string $text): string;
    public function createFile($content);
}
