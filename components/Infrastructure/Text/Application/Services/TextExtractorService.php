<?php

namespace Components\Infrastructure\Text\Application\Services;

use Components\Infrastructure\Image\Domain\Interfaces\ImageTextExtractorInterface;
use Components\Infrastructure\Pdf\Domain\Interfaces\PdfImageConverterInterface;
use Components\Infrastructure\Pdf\Domain\Interfaces\PdfImageExtractorInterface;
use Components\Infrastructure\Pdf\Domain\Interfaces\PdfTextExtractorInterface;
use Components\Infrastructure\Text\Domain\Interfaces\TextExtractorServiceInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class TextExtractorService implements TextExtractorServiceInterface
{
    protected $pdftext;
    protected $pdfimg;
    protected $pdfconv;
    protected $imgtext;
    protected $config;

    public function __construct(
        PdfTextExtractorInterface $pdftext,
        PdfImageExtractorInterface $pdfimg,
        PdfImageConverterInterface $pdfconv,
        ImageTextExtractorInterface $imgtext,
        array $config = []
    ) {
        $this->pdftext = $pdftext;
        $this->pdfimg = $pdfimg;
        $this->pdfconv = $pdfconv;
        $this->imgtext = $imgtext;
        $this->config = $config;
    }

    public function getContents(\SplFileInfo $file, bool $is_pdf_image = false): string
    {
        $mime = mime_content_type($file->getPathname());

        if ($mime == 'application/pdf') {
            return $this->getTextFromPdf($file, $is_pdf_image);
        }

        if (Str::startsWith($mime, 'image/')) {
            return $this->getTextFromImage($file);
        }

        if (Str::startsWith($mime, 'text/')) {
            return file_get_contents($file->getPathname());
        }

        throw new \UnexpectedValueException("Unable to get text: unexpected mime type '{$mime}'");
    }

    public function getLines(\SplFileInfo $file): array
    {
        $lines = explode("\n", $this->getContents($file));
        $lines = array_map('trim', $lines);
        $lines = array_filter($lines);

        return $lines;
    }

    protected function getTextFromPdf(\SplFileInfo $file, bool $is_pdf_image = false): string
    {
        if (!$is_pdf_image && $this->pdftext->hasText($file)) {
            return $this->pdftext->getText($file);
        }

        if ($is_pdf_image || $this->pdfimg->hasImages($file)) {
            return $this->getTextFromPdfImages($file);
        }

        throw new \RuntimeException("unable to find any text: {$file->getPathname()}");
    }

    protected function getTextFromPdfImages(\SplFileInfo $file): string
    {
        $imageFile = $this->pdfconv->convert($file);
        $text = $this->getTextFromImage($imageFile);
        unlink($imageFile->getRealPath());
        return $text;
    }

    protected function getTextFromImage(\SplFileInfo $file): string
    {
        return $this->imgtext->getText($file);
    }
}
