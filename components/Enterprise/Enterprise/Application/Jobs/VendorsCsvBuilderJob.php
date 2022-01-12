<?php

namespace Components\Enterprise\Enterprise\Application\Jobs;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Repositories\Addworking\Enterprise\VendorRepository;
use Carbon\Carbon;
use Components\Enterprise\Enterprise\Application\Builders\VendorsCsvBuilder;
use Components\Infrastructure\Export\Application\Models\Export;
use Components\Infrastructure\Export\Application\Repositories\ExportRepository;
use Components\Infrastructure\Export\Application\Repositories\FileRepository;
use Components\Infrastructure\Export\Domain\Interfaces\ExportEntityInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class VendorsCsvBuilderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Export
     */
    protected $export;

    /**
     * @var Enterprise
     */
    protected $customer;

    /**
     * @var iterable
     */
    protected $data;

    public function __construct(
        Export $export,
        Enterprise $customer
    ) {
        $this->export = $export;
        $this->customer = $customer;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $exportRepository = app(ExportRepository::class);
        try {
            $data = $this->getData();
            $builder = $this->createBuilder($data);
            $file = $this->createFile($builder);
            $this->createExport($exportRepository, $file);
        } catch (\Exception $e) {
            $this->handleException($e, $exportRepository);
        }
    }

    private function getData()
    {
        return app(VendorRepository::class)->list(null, $this->export->getFilters())
            ->whereIsVendor()
            ->vendorOf($this->customer)
            ->get();
    }

    private function createBuilder($data)
    {
        $builder = new VendorsCsvBuilder();
        $builder->includeDocumentTypeHeader($this->customer);
        $builder->setCustomer($this->customer);
        $builder->addAll($data);
        return $builder;
    }

    private function createExport(ExportRepository $exportRepository, $file)
    {
        $this->export->setFile($file);
        $this->export->setStatus(ExportEntityInterface::STATUS_GENERATED);
        $this->export->setFinishedAt(Carbon::now());
        $this->export = $exportRepository->save($this->export);
    }

    private function createFile($builder)
    {
        $fileRepository = app(FileRepository::class);
        $file = $fileRepository->createExportFile($builder->getPathName());
        return $fileRepository->save($file);
    }

    private function handleException(\Exception $e, ExportRepository $exportRepository)
    {
        $this->export->setErrorMessage(
            "File: {$e->getFile()} 
                Line: {$e->getLine()} 
                Trace: {$e->getTraceAsString()}"
        );
        $this->export->setFinishedAt(Carbon::now());
        $this->export->setStatus(ExportEntityInterface::STATUS_FAILED);
        $exportRepository->save($this->export);
    }
}
