<?php

namespace Components\Enterprise\Document\Application\Repositories;

use App\Models\Addworking\Common\File;
use Components\Common\Common\Domain\Interfaces\CsvToPdfConvertorInterface;
use Components\Enterprise\Document\Application\Models\Document;
use Components\Enterprise\Document\Domain\Exceptions\DocumentCreationFailedException;
use Components\Enterprise\Document\Domain\Interfaces\Entities\DocumentEntityInterface;
use Components\Enterprise\Document\Domain\Interfaces\Repositories\DocumentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class DocumentRepository implements DocumentRepositoryInterface
{
    public function make(): DocumentEntityInterface
    {
        return new Document();
    }

    public function save(Document $document): ?DocumentEntityInterface
    {
        try {
            $document->save();
        } catch (DocumentCreationFailedException $exception) {
            throw $exception;
        }

        $document->refresh();

        return $document;
    }

    public function findByYousignProcedureId(string $id): ?DocumentEntityInterface
    {
        return Document::where('yousign_procedure_id', $id)->first();
    }

    public function createFile($content)
    {
        return File::from($content)
            ->fill(['mime_type' => "application/pdf"])
            ->name("/document_signed_%uniq%.pdf")
            ->saveAndGet();
    }

    /**
     * @param Document $document
     * @param $file
     */
    public function saveFile(Document $document, $file)
    {
        if (strtolower($file->getClientOriginalExtension()) === "csv") {
            $file = File::from($file);
            $convertor = App::make(CsvToPdfConvertorInterface::class);
            $pdf = $convertor->convert($file);
            $file = File::from($pdf)->fill(['mime_type' => "application/pdf"])->saveAndGet();
        } else {
            $file   = File::from($file)->saveAndGet();
        }
        $document->setRequiredDocument($file);
        $document->save();
    }

    /**
     * @param Document $document
     * @return File
     */
    public function mergeDocumentPdf(Document $document): File
    {
        $pdf_options = ["-q","-dNOPAUSE","-dBATCH","-dNOSAFER","-sDEVICE=pdfwrite","-dCompatibilityLevel=1.4",
            "-dPDFSETTINGS=/screen","-dAutoRotatePages=/None","-dEmbedAllFonts=true","-dSubsetFonts=true"];

        $dir_temp = storage_path('temp/' . uniqid('files_merged'));

        if (! is_dir($dir_temp)) {
            mkdir($dir_temp);
        }
        $input_files = $this->getFilesOf($document, $dir_temp);

        $output_file = "{$dir_temp}/{$document->getDocumentTypeModel()->getName()}".uniqid("").".pdf";
        $options = implode(" ", $pdf_options);
        $input = implode(" ", $input_files);

        try {
            exec($cmd = "gs $options -sOutputFile={$output_file} {$input}");
        } catch (\Exception $e) {
            Log::warning("unable to run command '{$cmd}' : {$e}");
        }

        return new File([
            'path'      => $output_file,
            'mime_type' => 'pdf',
            'content'   => file_get_contents($output_file),
        ]);
    }

    private function getFilesOf(Document $document, $dir_temp): array
    {
        $input_files = [];

        $files = new Collection();
        $files->push($document->files()->first());
        $files->push($document->getRequiredDocument());

        foreach ($files as $file) {
            $path = "{$dir_temp}/".uniqid('original_').".{$file->extension}";
            if (! file_put_contents($path, $file->content)) {
                throw new \RuntimeException("unable to write '{$path}'");
            }

            $input_files[] = $path;
        }

        return $input_files;
    }
}
