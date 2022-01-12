<?php

namespace Components\Infrastructure\PdfManager\Application;

use Components\Infrastructure\PdfManager\Domain\Classes\PdfManagerInterface;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade as PDF;
use setasign\Fpdi\Fpdi;

class PdfManager implements PdfManagerInterface
{
    protected const GS_PDF_OPTIONS = [
        "-q",
        "-dNOPAUSE",
        "-dBATCH",
        "-dNOSAFER",
        "-sDEVICE=pdfwrite",
        "-dCompatibilityLevel=1.4",
        "-dPDFSETTINGS=/screen",
        "-dAutoRotatePages=/None",
        "-dEmbedAllFonts=true",
        "-dSubsetFonts=true",
    ];

    public function saveFromString(string $file_content, string $saved_path): void
    {
        if (! file_put_contents($saved_path, $file_content)) {
            throw new \RuntimeException("unable to write '{$saved_path}'");
        }
    }

    public function merge(array $input_file_paths, string $output_file): void
    {
        $options = implode(" ", self::GS_PDF_OPTIONS);
        $input = implode(" ", $input_file_paths);
        $cmd = "gs $options -sOutputFile={$output_file} {$input}";

        try {
            exec($cmd);
        } catch (\Exception $e) {
            Log::warning("unable to run command '{$cmd}' : {$e}");
        }
    }

    public function compress(string $original_file, string $compressed_file): void
    {
        $options = implode(" ", self::GS_PDF_OPTIONS);
        $cmd = "gs $options -sOutputFile={$compressed_file} {$original_file}";

        try {
            exec($cmd);
        } catch (\Exception $e) {
            Log::warning("unable to run command '{$cmd}' : {$e}");
        }
    }

    public function imageToPdf(string $input_image_path, string $output_pdf_path): void
    {
        $fpdf = new Fpdi();
        $fpdf->AddPage();
        $fpdf->Image($input_image_path, null, null, 190, 0);
        $fpdf->Output('F', $output_pdf_path);
        $fpdf->Close();
    }

    public function resizeImage(string $original_image_path, string $resized_image_path): void
    {
        $image = new \Imagick();
        $image->readImage($original_image_path);
        $image->setResolution(150, 150);
        $image->setImageCompressionQuality(60);
        $image->adaptiveResizeImage(1754, 1240, true);
        $image->writeImage($resized_image_path);
        $image->destroy();
    }

    public function htmlToPdf(string $html, string $textfooter = null, bool $landscape = false)
    {
        $pdf = PDF::loadHTML($html);

        $canvas = $pdf->getDomPDF()->get_canvas();

        if ($landscape) {
            $pdf->getDomPDF()->set_paper("a4", "landscape");
        }

        $canvas->page_text(490, 800, "Page {PAGE_NUM} / {PAGE_COUNT}", null, 8);

        if (! is_null($textfooter)) {
            $canvas->page_text(71, 785, "{$textfooter}", null, 8);
        }

        return $pdf;
    }
}
