<?php

namespace Components\Common\Common\Domain\UseCases;

use Components\Common\Common\Domain\Interfaces\FileImmutableInterface;
use Components\Common\Common\Domain\Interfaces\FileRepositoryInterface;
use Components\Infrastructure\Text\Domain\Interfaces\TextExtractorServiceInterface;

class CreateFullText
{
    protected $files;

    protected $text;

    public function __construct(
        FileRepositoryInterface $files,
        TextExtractorServiceInterface $text
    ) {
        $this->files = $files;
        $this->text = $text;
    }

    public function handle(FileImmutableInterface $file)
    {
        // no conversion is actually needed if the file is already a
        // text format (text/plain, text/html, text/xml etc.)
        if ($file->isText()) {
            return $file;
        }

        $text = $this->files->make()
            ->setParent($file)
            ->setOwner($file->getOwner())
            ->setName(sprintf("%s-%s.txt", $file->id, uniqid('t')))
            ->setMimeType('text/plain')
            ->setContent(
                $this->text->getContents(
                    $file->getFileInfo()
                )
            );

        if (! $this->files->save($text)) {
            throw new \RuntimeException(
                "unable to store new text file"
            );
        }

        return $text;
    }
}
