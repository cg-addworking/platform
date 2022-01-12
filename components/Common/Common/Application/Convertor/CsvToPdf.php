<?php

namespace Components\Common\Common\Application\Convertor;

use App\Models\Addworking\Common\File;
use Components\Common\Common\Domain\Exceptions\FileIsNotReadableException;
use Components\Common\Common\Domain\Interfaces\CsvToPdfConvertorInterface;
use Components\Infrastructure\PdfManager\Application\PdfManager;
use Illuminate\Support\Facades\App;

class CsvToPdf implements CsvToPdfConvertorInterface
{
    /**
     * convert a csv file to html then to pdf
     * @param File $file
     * @return mixed
     */
    public function convert(File $file)
    {
        //read all lines of the file
        $lines = preg_split('#\r?\n#', $file->content, 0);

        $html = $this->getHtmlStart();

        //get csv delimiter from the first line
        $line_separator = $this->detectDelimiter($lines[0]);

        if (!$line_separator) {
            throw new FileIsNotReadableException();
        }

        $html = $this->addCsvContentTo($html, $lines, $line_separator);

        $html = $this->getHtmlEnd($html);

        //convert html to pdf
        return App::make(PdfManager::class)->htmlToPdf($html, null, true)->output();
    }

    /**
     * @return string
     */
    private function getHtmlStart(): string
    {
        $html = '<html><head>';

        $html .= '<style>
               footer { position: fixed; bottom: -60px; height: 50px; left: 0px; right: 0px;}
               @page { margin: 2cm 1cm; }
               body {
                   width: 100%;
               }
               table {
                    width: 100%;
                    border-collapse: collapse;
               }
              tr {
                width: 100%;
              }
               table, td, th {
                    border: 1px solid black;
               }
               </style>';
        $html .= '</head>';
        $html .= '<footer></footer>';
        $html .= '<body>';
        $html .= '<table>';

        return $html;
    }

    /**
     * @param $html
     * @return string
     */
    private function getHtmlEnd($html): string
    {
        $html .= '</table>';
        $html .= '</body>';
        $html .= '</html>';

        return $html;
    }

    /**
     * @param $line
     * @return false|int|string
     */
    private function detectDelimiter($line)
    {
        //detects csv delimiters. It counts predefined delimiter possibilities from the first row
        $delimiters = array(
            ';' => 0,
            ',' => 0,
            "\t" => 0,
            "|" => 0
        );

        foreach ($delimiters as $delimiter => &$count) {
            $count = count(str_getcsv($line, $delimiter));
        }

        return array_search(max($delimiters), $delimiters);
    }

    /**
     * @param string $html
     * @param array $lines
     * @param string $line_separator
     * @return string
     */
    private function addCsvContentTo(string $html, array $lines, string $line_separator): string
    {
        foreach ($lines as $key => $content) {
            $line = explode($line_separator, $content);

            $html .= '<tr>';
            if ($key == 0) {
                //first we get the headers of the csv file
                foreach ($line as $item) {
                    $html .= '<th>'. $item .'</th>';
                }
            } else {
                foreach ($line as $item) {
                    $html .= '<td>'. $item .'</td>';
                }
            }
            $html .= '</tr>';
        }

        return $html;
    }
}
