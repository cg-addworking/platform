<?php

namespace App\Jobs\Addworking\Contract\Contract;

use App\Models\Addworking\Common\File;
use App\Models\Addworking\Contract\Contract;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\UploadedFile;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class UpdateContractJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $contract;
    public $file;
    public $properties;

    public function __construct(Contract $contract, array $properties, ?UploadedFile $file = null)
    {
        $this->contract = $contract;
        $this->properties = $properties;
        $this->file = $file;
    }

    public function handle()
    {
        return DB::transaction(function () {
            $this->contract->fill($this->properties);

            if ($this->file) {
                $this->file = tap(File::from($this->file), fn($file) => $file->save());
                $this->contract->file()->associate($this->file);
            }

            return $this->contract->save();
        });
    }
}
