<?php

namespace Components\Infrastructure\PdfManager\Domain\Classes;

interface PdfManagerInterface
{
    public function saveFromString(string $pdf_content, string $saved_path): void;
    public function merge(array $input_file_paths, string $output_file): void;
    public function compress(string $original_file, string $compressed_file): void;
    public function imageToPdf(string $input_image_path, string $output_pdf_path): void;
    public function resizeImage(string $original_image_path, string $resized_image_path): void;
    public function htmlToPdf(string $html, string $textfooter = null, bool $landscape = false);
}
