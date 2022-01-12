<?php

namespace Components\Infrastructure\FileDataExtractor\Application\Services;

use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentSplitterServiceInterface;
use setasign\Fpdi\Fpdi;

class DocumentSplitterService implements DocumentSplitterServiceInterface
{
    public function splitPdf($filename): array
    {
        $pdf = new FPDI();
        $page_count = $pdf->setSourceFile($filename); // How many pages?

        // Split each page into a new PDF
        $splited_files = [];
        for ($i = 1; $i <= $page_count; $i++) {
            $newPdf = new FPDI();
            $newPdf->AddPage();
            $newPdf->setSourceFile($filename);
            $newPdf->useTemplate($newPdf->importPage($i));

            try {
                $new_filename = str_replace('.pdf', '', $filename).'_'.$i.".pdf";
                $newPdf->Output($new_filename, "F");
                $splited_files[] = $new_filename;
            } catch (\Exception $e) {
                return [];
            }
        }
        return $splited_files;
    }
}
