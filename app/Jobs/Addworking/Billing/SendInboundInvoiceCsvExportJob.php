<?php

namespace App\Jobs\Addworking\Billing;

use App\Models\Addworking\User\User;
use Carbon\Carbon;
use Components\Infrastructure\Export\Application\Models\Export;
use Components\Infrastructure\Export\Application\Repositories\ExportRepository;
use Components\Infrastructure\Export\Application\Repositories\FileRepository;
use Components\Infrastructure\Export\Domain\Interfaces\ExportEntityInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Addworking\Billing\InboundInvoiceCsvExportNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\App;
use App\Models\Addworking\Billing\InboundInvoiceCsvBuilder;

class SendInboundInvoiceCsvExportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $inbound_invoices;
    public $user;
    public $export;
    public $exportRepository;

    public function __construct(
        User $user,
        $inbound_invoices,
        Export $export,
        ExportRepository $exportRepository
    ) {
        $this->user = $user;
        $this->inbound_invoices = $inbound_invoices;
        $this->export = $export;
        $this->exportRepository = $exportRepository;
    }

    public function handle()
    {
        try {
            $builder = $this->createBuilder($this->inbound_invoices);
            $file = $this->createFile($builder);
            $this->createExport($file);
            $url = route('infrastructure.export.download', $this->export);

            Notification::send(
                $this->user,
                new InboundInvoiceCsvExportNotification($url, $this->user)
            );
        } catch (\Exception $e) {
            $this->export->setErrorMessage(
                "File: {$e->getFile()} 
                    Line: {$e->getLine()} 
                    Trace: {$e->getTraceAsString()}"
            );
            $this->export->setStatus(ExportEntityInterface::STATUS_FAILED);
            $this->export->setFinishedAt(Carbon::now());
            $this->exportRepository->save($this->export);
        }
    }

    private function createBuilder($inbound_invoices)
    {
        $builder = new InboundInvoiceCsvBuilder();
        $builder->addAll($inbound_invoices);
        return $builder;
    }

    private function createExport($file)
    {
        $this->export->setFile($file);
        $this->export->setStatus(ExportEntityInterface::STATUS_GENERATED);
        $this->export->setFinishedAt(Carbon::now());
        $this->exportRepository->save($this->export);
    }

    private function createFile($builder)
    {
        $fileRepository = App::make(FileRepository::class);
        $file = $fileRepository->createExportFile($builder->getPathName());
        return $fileRepository->save($file);
    }
}
