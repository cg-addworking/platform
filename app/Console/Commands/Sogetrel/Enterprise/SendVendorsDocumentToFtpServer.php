<?php

namespace App\Console\Commands\Sogetrel\Enterprise;

use App\Models\Addworking\Enterprise\Document;
use Illuminate\Console\Command;
use App\Models\Addworking\Enterprise\DocumentType;
use App\Models\Addworking\Enterprise\Enterprise;
use Illuminate\Http\File;
use App\Models\Addworking\Common\File as FileDB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;

class SendVendorsDocumentToFtpServer extends Command
{
    const DOCUMENT_TYPES = [
        'KB' => 'certificate_of_establishment',
        'AC' => 'certificate_of_payment_social_contribution',
        'AA' => 'certificate_of_professionnal_liability',
        'AH' => 'certificate_of_employee_outside_the_eu'
    ];

    protected $signature = 'sogetrel:enterprise:send-documents-to-ftp';
    protected $description = 'Send a Sogetrel vendors documents to an FTP server';
    protected $date;
    protected $documents = [];
    protected $xml;
    protected $path;
    protected $temp_dir;
    protected $pdf_options = [
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

    public function __construct()
    {
        if (! function_exists('exec')) {
            throw new \RuntimeException("the 'exec' function is mandatory for this command");
        }

        parent::__construct();

        $this->date = date('YmdHis');
    }

    public function handle()
    {
        $this->prepareXml()->generateXml()->generateZip()->send();
    }

    protected function prepareXml()
    {
        /**
         * @deprecated v0.5.55 replace with Sogetrel::enterprise()
         */
        $family = Enterprise::fromName('SOGETREL')->family();

        $vendors = Enterprise::whereHas('customers', function ($query) use ($family) {
            return $query->whereIn('id', $family->pluck('id'));
        })->cursor();

        foreach ($vendors as $vendor) {
            if ($vendor->sogetrelData()->exists() && $vendor->sogetrelData->navibat_sent) {
                $this->documents[] = $this->prepareData($vendor);
            }
        }

        Log::info('Sogetrel FTP Server: prepare xml action finished successfully');

        return $this;
    }

    protected function prepareData(Enterprise $vendor)
    {
        $status = 1;
        $data = [];

        foreach (self::DOCUMENT_TYPES as $key => $type) {
            $document = $vendor->documents()->ofDocumentType(DocumentType::fromName($type))->onlyValidated()
                ->latest()->first();

            $data[$key] = is_null($document) ? "0" : "1";

            if (! is_null($document)) {
                $data['documents'][$key] = $document->id;
            }

            if (is_null($document)) {
                $status = 0;
            }
        }

        $data['navibat_id'] = $vendor->sogetrelData->navibat_id;
        $data['siren']      = substr($vendor->identification_number, 0, 9);
        $data['status']     = $status;

        return $data;
    }

    protected function generateXml()
    {
        $this->xml = view('sogetrel.enterprise.document.vendor.xml', [
            'vendors' => $this->documents, 'date' => $this->date
        ])->render();

        Log::info('Sogetrel FTP Server: generate xml action finished successfully');

        return $this;
    }

    protected function generateZip()
    {
        $dir_to_zip = storage_path('temp/' . uniqid("files_to_zip_"));

        if (! is_dir($dir_to_zip)) {
            mkdir($dir_to_zip);
        }

        if (! file_put_contents($path = "{$dir_to_zip}/{$this->date}.xml", $this->xml)) {
            throw new \RuntimeException("unable to write '{$path}'");
        }

        $this->generateFiles($dir_to_zip);

        $this->path = storage_path("temp/{$this->date}.zip");

        $zip_arg = escapeshellarg($this->path);
        $dir_arg = escapeshellarg($dir_to_zip);

        // -r stands for recursive
        // -j stands for junk (forget about paths in Zip archive)
        exec($cmd = "zip -j -r {$zip_arg} {$dir_arg}", $output, $return_var);

        if (! $return_var == "0") {
            throw new \RuntimeException("unable to run command '{$cmd}'");
        }

        Log::info('Sogetrel FTP Server: generate zip action finished successfully');

        return $this;
    }

    protected function generateFiles(string $dir_to_zip)
    {
        $dir_temp = storage_path('temp/' . uniqid('files_generated_'));

        if (! is_dir($dir_temp)) {
            mkdir($dir_temp);
        }

        foreach ($this->documents as $vendor) {
            if ($vendor['status'] == 0) {
                continue;
            }

            foreach ($vendor['documents'] as $type => $id) {
                $document = Document::find($id);

                if (is_null($document)) {
                    continue;
                }

                $file_count = count($document->files);

                if ($file_count == 0) {
                    unset($document);
                    continue;
                }

                if ($file_count > 1) {
                    $input_files = [];
                    foreach ($document->files as $file) {
                        if (in_array($file->mime_type, ["image/jpeg", "image/png"])) {
                            $path = $this->convertToPdf($file, $dir_temp);
                        } else {
                            $path = "{$dir_temp}/".uniqid('original_').".{$file->extension}";
                            if (! file_put_contents($path, $file->content)) {
                                throw new \RuntimeException("unable to write '{$path}'");
                            }
                        }

                        $input_files[] = $path;
                    }

                    try {
                        $name_file_merged = "{$vendor['navibat_id']}{$type}{$document->valid_until->format('Ymd')}.pdf";
                        $output_file = "{$dir_to_zip}/{$name_file_merged}";

                        $this->mergePdf($input_files, $output_file);
                    } catch (\Exception $e) {
                        Log::warning("{$e->getMessage()} for document {$id}");
                    }
                } else {
                    $file = $document->files()->first();
                    $name = "{$vendor['navibat_id']}{$type}{$document->valid_until->format('Ymd')}.pdf";

                    if (in_array($file->mime_type, ["image/jpeg", "image/png"])) {
                        $this->convertToPdf($file, $dir_temp, "{$dir_to_zip}/{$name}");
                    } else {
                        if (! file_put_contents($path = "{$dir_temp}/{$name}", $file->content)) {
                            throw new \RuntimeException("unable to write '{$path}'");
                        }

                        $this->compressPdf($path, "{$dir_to_zip}/{$name}");
                    }
                }

                unset($document);
                gc_collect_cycles();
            }
        }
    }

    protected function send()
    {
        if ($this->laravel->environment('local')) {
            return $this;
        }

        Storage::disk('sogetrel')->putFileAs('/', new File($this->path), basename($this->path));

        if (! Storage::disk('sogetrel')->exists(basename($this->path))) {
            Log::error("Sogetrel FTP Server: {$this->path} ZIP file has not been uploaded");
        }

        Log::info("Sogetrel FTP Server: ZIP file uploaded");

        return $this;
    }

    private function convertToPdf(FileDB $file, string $dir_temp = null, string $destination_path = null): ?string
    {
        if (is_null($dir_temp)) {
            $dir_temp = storage_path('temp/' . uniqid());
        }

        if (! is_dir($dir_temp)) {
            mkdir($dir_temp);
        }

        $uniqid = uniqid();
        $file_path = "{$dir_temp}/original_{$uniqid}.{$file->extension}";
        if (! file_put_contents($file_path, $file->content)) {
            throw new \RuntimeException("unable to write '{$file_path}'");
        }

        if (is_null($destination_path)) {
            $destination_path = "{$dir_temp}/converted_{$uniqid}.pdf";
        }

        try {
            $image_resized_path = "{$dir_temp}/resized_{$uniqid}.{$file->extension}";
            $this->resizeImage($file_path, $image_resized_path);
            $this->imageToPdf($image_resized_path, $destination_path);
        } catch (\Exception $e) {
            Log::warning("Imagick - FPDF: {$e->getMessage()} for file {$file->id}");
        }

        return $destination_path;
    }

    private function imageToPdf(string $image_path, string $pdf_path): void
    {
        $fpdf = new Fpdi();
        $fpdf->AddPage();
        $fpdf->Image($image_path, null, null, 190, 0);
        $fpdf->Output('F', $pdf_path);
        $fpdf->Close();
    }

    private function resizeImage(string $original_path, string $resized_path): void
    {
        $image = new \Imagick();
        $image->readImage($original_path);
        $image->setResolution(150, 150);
        $image->setImageCompressionQuality(60);
        $image->adaptiveResizeImage(1754, 1240, true);
        $image->writeImage($resized_path);
        $image->destroy();
    }

    private function mergePdf(array $input_files, string $output_file)
    {
        $options = implode(" ", $this->pdf_options);
        $input = implode(" ", $input_files);

        try {
            exec($cmd = "gs $options -sOutputFile={$output_file} {$input}");
        } catch (\Exception $e) {
            Log::warning("unable to run command '{$cmd}' : {$e}");
        }
    }

    private function compressPdf(string $original_file, string $compressed_file)
    {
        $options = implode(" ", $this->pdf_options);

        try {
            exec($cmd = "gs $options -sOutputFile={$compressed_file} {$original_file}");
        } catch (\Exception $e) {
            Log::warning("unable to run command '{$cmd}' : {$e}");
        }
    }
}
