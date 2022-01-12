<?php

namespace App\Jobs\Addworking\Contract\Contract;

use App\Jobs\Addworking\Contract\Contract\CreateBlankContractJob;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Enterprise\Enterprise;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\UploadedFile;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class CreateContractFromExistingFileJob extends CreateBlankContractJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $contract;
    public $enterprise;
    public $file;
    public $uploadedFile;

    public function __construct(Enterprise $enterprise, array $properties, UploadedFile $file)
    {
        parent::__construct($enterprise, $properties);

        $this->properties = $properties;
        $this->uploadedFile = $file;
        $this->enterprise = $enterprise;
    }

    public function handle()
    {
        return DB::transaction(function () {
            if (! parent::handle()) {
                return false;
            }

            $this->file = File::from($this->uploadedFile);
            $this->file->save();

            $this->contract->file()->associate($this->file);
            return $this->contract->save();
        });
    }
}
