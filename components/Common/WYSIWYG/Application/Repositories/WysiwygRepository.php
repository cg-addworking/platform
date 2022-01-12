<?php

namespace Components\Common\WYSIWYG\Application\Repositories;

use App\Models\Addworking\Common\File;
use Components\Common\WYSIWYG\Domain\Interfaces\Repositories\WysiwygRepositoryInterface;
use Components\Infrastructure\PdfManager\Application\PdfManager;
use Illuminate\Support\Facades\App;

class WysiwygRepository implements WysiwygRepositoryInterface
{
    public function formatTextForPdf(string $text): string
    {
        $text = \Normalizer::normalize($text);

        $html = '<html><head>';
        $html .= '<style> 
                        @page { margin: 2.5cm 1.5cm; } 
                        * { word-break: break-word; word-wrap: break-word; }
                        body { width: 100%; } 
                        footer { position: fixed; bottom: -60px; height: 50px; left: 0px; right: 0px;}
                        .page_break { page-break-before: always; }
                    </style>';
        $html .= '</head>';
        $html .= '<footer></footer>';
        $html .= '<body>';
        $html .= $text;
        $html .= '</body>';
        $html .= '</html>';
        $html = str_replace('<!-- pagebreak -->', '<span class="page_break"></span>', $html);

        return $html;
    }

    public function createFile($content)
    {
        $pdf = App::make(PdfManager::class)->htmlToPdf($content)->output();

        return File::from($pdf)
            ->fill(['mime_type' => "application/pdf"])
            ->name("/". uniqid() ."-%ts%.pdf")
            ->saveAndGet();
    }
}
