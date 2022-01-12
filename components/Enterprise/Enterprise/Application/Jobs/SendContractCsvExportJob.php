<?php

namespace Components\Enterprise\Enterprise\Application\Jobs;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Carbon\Carbon;
use Components\Contract\Contract\Application\Notifications\ContractExportNotification;
use Components\Enterprise\Enterprise\Application\Builders\ContractCsvBuilder;
use Components\Infrastructure\Export\Application\Models\Export;
use Components\Infrastructure\Export\Application\Repositories\ExportRepository;
use Components\Infrastructure\Export\Application\Repositories\FileRepository;
use Components\Infrastructure\Export\Domain\Interfaces\ExportEntityInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class SendContractCsvExportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var Export
     */
    protected $export;

    /**
     * @var Enterprise
     */
    protected $enterprise;

    protected $contracts;

    /**
     * @var iterable
     */
    protected $data;

    public function __construct(
        User $user,
        Export $export,
        Enterprise $enterprise,
        $contracts
    ) {
        $this->user = $user;
        $this->export = $export;
        $this->enterprise = $enterprise;
        $this->contracts = $contracts;
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
            $builder = $this->createBuilder($this->contracts, $this->user);
            $file = $this->createFile($builder);
            $this->createExport($exportRepository, $file);
            $download_url = route('infrastructure.export.download', $this->export);

            Notification::send(
                $this->user,
                new ContractExportNotification(
                    $this->enterprise,
                    $download_url
                )
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getLine());
            $this->handleException($e, $exportRepository);
        }
    }

    private function createBuilder($contracts, $user)
    {
        $builder = new ContractCsvBuilder($user);
        $builder->includeHeader($contracts);
        $builder->addAll($contracts);
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
