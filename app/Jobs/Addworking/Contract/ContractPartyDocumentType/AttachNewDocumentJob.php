<?php

namespace App\Jobs\Addworking\Contract\ContractPartyDocumentType;

use App\Jobs\Addworking\Contract\ContractPartyDocumentType\AttachExistingDocumentJob;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Contract\ContractPartyDocumentType;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\UploadedFile;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class AttachNewDocumentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $contractPartyDocumentType;
    public $document;
    public $file;

    public function __construct(ContractPartyDocumentType $type, UploadedFile $file)
    {
        $this->contractPartyDocumentType = $type;
        $this->file = $file;
    }

    public function handle()
    {
        return DB::transaction(function () {
            $enterprise = $this->contractPartyDocumentType->contractParty->enterprise;
            $this->file = tap(File::from($this->file), fn($file) => $file->save());

            $this->document = $enterprise
                ->documents()
                ->make(['valid_from' => Carbon::now()]);

            $this->document
                ->documentType()
                ->associate($this->contractPartyDocumentType->documentType);

            $this->document
                ->enterprise()
                ->associate($enterprise);

            $this->document
                ->save();

            $this->document
                ->files()
                ->attach($this->file);

            return (new AttachExistingDocumentJob(
                $this->contractPartyDocumentType,
                $this->document
            ))->handle();
        });
    }
}
