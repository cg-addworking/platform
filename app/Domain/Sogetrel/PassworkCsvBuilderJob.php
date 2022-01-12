<?php

namespace App\Domain\Sogetrel;

use App\Models\Sogetrel\User\Passwork;
use Carbon\Carbon;
use Components\Infrastructure\Export\Application\Models\Export;
use Components\Infrastructure\Export\Application\Repositories\ExportRepository;
use Components\Infrastructure\Export\Application\Repositories\FileRepository;
use Components\Infrastructure\Export\Domain\Interfaces\ExportEntityInterface;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PassworkCsvBuilderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Export
     */
    protected $export;

    protected $request;

    /**
     * @var iterable
     */
    protected $data;

    public function __construct(
        Export $export,
        ?array $request
    ) {
        $this->export = $export;
        $this->request = $request;
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
            $data = $this->getData($this->request);
            $builder = $this->createBuilder($data);
            $file = $this->createFile($builder);
            $this->createExport($exportRepository, $file);
        } catch (\Exception $e) {
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

    private function getData($request)
    {
        return Passwork::searchWithArray($request)
            ->with('departments')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    private function createBuilder($data)
    {
        return (new PassworkCsvBuilder)->addAll($data);
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
}
