<?php

namespace Components\Connector\Airtable\Application\Commands;

use Carbon\Carbon;
use Components\Connector\Airtable\Application\Client as Airtable;
use Components\Infrastructure\FileDataExtractor\Application\Extractors\Data\AttachementSogetrelData;
use Components\Infrastructure\FileDataExtractor\Application\Extractors\Data\PurchaseOrderSogetrelData;
use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentDataExtractorServiceInterface;
use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentSplitterServiceInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class ExtractDataFromSogetrelAttachmentFileCommand extends Command
{
    protected $signature = 'sogetrel:extract-data-from-attachment-file';

    protected $description = 'Extract data in Sogetrel attachment file from airtable';

    const TABLE = 'tblJNrUzYcKEYH4ws'; // import_docusign

    private array $mappingAttachementFields = [
        'docusign_envelope_id' => 'ocr_attachement_docusign_envelope_id',
        'contract_num'         => 'ocr_attachement_contract_num',
        'attachement_num'      => 'ocr_attachement_attachement_num',
        'total_eur_ht'         => 'ocr_attachement_total_eur_ht',
        'total_eur_ttc'        => 'ocr_attachement_total_eur_ttc',
        'total_eur_tva'        => 'ocr_attachement_total_eur_tva',
    ];

    private array $mappingPurchaseOrderFields = [
        'docusign_envelope_id'  => 'ocr_purchase_order_docusign_envelope_id',
        'command_number'        => 'ocr_purchase_order_command_number',
        'workfield_identifier'  => 'ocr_purchase_order_workfield_identifier',
        'total_eur_ht'          => 'ocr_purchase_order_total_eur_ht',
        'total_eur_tva'         => 'ocr_purchase_order_total_eur_tva',
        'total_eur_ttc'         => 'ocr_purchase_order_total_eur_ttc',
        'is_autoliquidee'       => 'ocr_purchase_order_is_autoliquidee',
        'reference'             => 'ocr_purchase_order_reference',
        'prestataire_oracle_id' => 'ocr_purchase_order_prestataire_oracle_id',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        if (! env('AIRTABLE_SOGETREL_ATTACHMENT_ENABLED')) {
            $this->error('Airtable: command disabled');
            return;
        }

        /*
        if (env('APP_ENV') != 'production') {
            $this->error('Airtable: env is not production');
            return;
        }
        */

        putenv(
            'GOOGLE_APPLICATION_CREDENTIALS='
            . config('ocr.google_application_credentials')
        );

        $query = "filterByFormula=AND({lu_par_ocr}=FALSE(),{Status}='4 - Document Lu',".
            "{Status (from GLOBAL 3) 2}='3 - Info manquante',{ocr_lecture_echec}=FALSE())";
        $query .= "&fields%5B%5D=DOC_AIRTABLE_URL";

        $client = new Airtable;
        $files = $client->getRecords(self::TABLE, $query);

        $this->info('Found ' . count($files->body->records) . ' files.' . PHP_EOL);
        foreach ($files->body->records as $record) {
            $this->info('Reading document id #' . $record->id . PHP_EOL);
            $fileUrl = null;
            if (isset($record->fields->DOC_AIRTABLE_URL)) {
                $fileUrl = $record->fields->DOC_AIRTABLE_URL;
            } else {
                $this->info('Can\'t find record URL for file #' . $record->id . PHP_EOL);
                $this->sendErrorToAirTable($client, $record->id, 'Can\'t find record URL for file #' . $record->id);
                continue;
            }

            $temp = tmpfile();
            $pdfPath = stream_get_meta_data($temp)['uri'];
            try {
                if (file_put_contents($pdfPath, file_get_contents($fileUrl))) {
                    $newPdf = $pdfPath.uniqid();
                    exec("gs -sDEVICE=pdfwrite -dCompatibilityLevel=1.7 -dNOPAUSE -dBATCH -sOutputFile=".
                        $newPdf." ".$pdfPath);
                    // we upgrade pdf version in case it is not compatible with our system

                    $splitedPdfs = App::make(DocumentSplitterServiceInterface::class)->splitPdf($newPdf);

                    if ($splitedPdfs === []) {
                        $this->info('Unable to split pdf for #' . $record->id . PHP_EOL);
                        $this->sendErrorToAirTable($client, $record->id, 'Unable to split pdf.');
                        continue;
                    }

                    $service = App::make(DocumentDataExtractorServiceInterface::class);
                    $fields = [];
                    foreach ($splitedPdfs as $splited_pdf) {
                        $extractor     = $service->extractDataFrom(new \SplFileInfo($splited_pdf));
                        if (is_null($extractor)) {
                            continue;
                        }

                        $extractedData = $extractor->toArray();
                        $fieldMapper = null;

                        if (is_a($extractor, PurchaseOrderSogetrelData::class)) {
                            $fieldMapper = $this->mappingPurchaseOrderFields;
                        } elseif (is_a($extractor, AttachementSogetrelData::class)) {
                            $fieldMapper = $this->mappingAttachementFields;
                        }

                        if (isset($fieldMapper)) {
                            foreach ($extractedData as $key => $value) {
                                if (isset($value) && array_key_exists($key, $fieldMapper)) {
                                    $fields[$fieldMapper[$key]] = $value;
                                }
                            }
                        }
                    }

                    unlink($pdfPath);
                    unlink($newPdf);
                    foreach ($splitedPdfs as $splited_pdf) {
                        unlink($splited_pdf);
                    }

                    if (!empty($fields)) {
                        $this->info('Updating airtable data for file #' . $record->id . PHP_EOL);
                        $fields['lu_par_ocr'] = true;
                        $fields['ocr_lecture_date'] = Carbon::now();
                        $client->updateRecord(self::TABLE, [
                            'records' => [
                                [
                                    'id' => $record->id,
                                    'fields' => $fields,
                                ],
                            ],
                        ]);
                    } else {
                        $this->info('No data were found for file #' . $record->id . PHP_EOL);
                        $this->sendErrorToAirTable($client, $record->id, 'No data were found for file.');
                    }
                } else {
                    $this->info('Unable to download file #' . $record->id . PHP_EOL);
                    $this->sendErrorToAirTable($client, $record->id, 'Unable to download file.');
                }
            } catch (\Exception $e) {
                $this->info('Something went wrong with file #' . $record->id . ':' . PHP_EOL . $e->getMessage());
                $this->sendErrorToAirTable($client, $record->id, 'Extraction Error:' . $e->getMessage());
                continue;
            }
        }
    }

    private function sendErrorToAirTable(Airtable $client, string $record_id, string $message)
    {
        $fields = [
            'ocr_lecture_echec' => true,
            'ocr_lecture_date' => Carbon::now(),
            'lecture_ocr_echec_message' => $message
        ];
        $client->updateRecord(self::TABLE, [
            'records' => [
                [
                    'id' => $record_id,
                    'fields' => $fields,
                ],
            ],
        ]);
    }
}
